<?php

declare(strict_types=1);

namespace App\Command\Import;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractImportCommand extends Command
{
    protected EntityManagerInterface $entityManager;
    protected LoggerInterface $logger;
    protected ValidatorInterface $validator;
    protected string $workingDirectory;

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'The CSV file path')
            ->addOption('batch-size', 'b', InputOption::VALUE_REQUIRED, 'Sets the batch size', '1000')
            ->addOption('delete', 'd', InputOption::VALUE_NONE, 'Delete existing data')
            ->addOption('truncate', 't', InputOption::VALUE_NONE, 'Delete existing data using SQL truncate')
            ->addOption('no-batch', 'B', InputOption::VALUE_NONE, 'Do not use batch import')
            ->addOption('no-warning', 'W', InputOption::VALUE_NONE, 'Do not display warnings during import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        gc_enable();

        $this->workingDirectory = dirname($input->getArgument('file'));

        $connection = $this->entityManager->getConnection();
        $connection
            ->getConfiguration()
            ->setSQLLogger();

        $io = new SymfonyStyle($input, $output);
        $stopwatch = new Stopwatch();

        if ($input->getOption('truncate')) {
            $io->writeln('Deleting existing data…');

            $connection = $this->entityManager->getConnection();
            $tableName = $this->entityManager
                ->getClassMetadata($this->getEntityClassName())
                ->getTableName();

            try {
                $platform = $connection->getDatabasePlatform();
                $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');
                $connection->executeStatement($platform->getTruncateTableSQL($tableName, true));
                $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $io->error('Unable to delete existing data!');

                return self::FAILURE;
            }

            $io->success('Existing data has been deleted.');
        }

        if ($input->getOption('delete')) {
            $io->writeln('Deleting existing data…');

            /** @phpstan-ignore-next-line */
            $entities = $this->entityManager
                ->getRepository($this->getEntityClassName())
                ->findAll();

            $progressBar = new ProgressBar($output, count($entities));
            $progressBar->setRedrawFrequency(10);
            $progressBar->display();

            foreach ($entities as $entity) {
                $this->entityManager->remove($entity);
                $progressBar->advance();
            }

            $this->entityManager->flush();
            $this->entityManager->clear();

            $progressBar->clear();
            $io->success('Existing data has been deleted.');
        }

        $stopwatch->start('import');

        $message = sprintf('Importing data from file "%s"…', $input->getArgument('file'));
        $this->logger->info($message);
        $io->writeln($message);

        try {
            $reader = Reader::createFromPath($input->getArgument('file'));
            $reader->setHeaderOffset(0);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $progressBar = new ProgressBar($output, $reader->count());
        $progressBar->setRedrawFrequency(10);
        $progressBar->display();

        $imported = 0;

        foreach ($reader->getRecords() as $row => $data) {
            try {
                $entity = $this->createOrUpdateEntity($data);
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $io->error($exception->getMessage());

                return self::FAILURE;
            }

            if (count($violations = $this->validator->validate($entity)) !== 0) {
                $progressBar->clear();

                foreach ($violations as $violation) {
                    $message = sprintf(
                        'Invalid data encountered at row %s for property "%s": %s',
                        $row,
                        $violation->getPropertyPath(),
                        $violation->getMessage()
                    );

                    if (!$input->getOption('no-warning')) {
                        $this->logger->warning($message);
                        $io->warning($message);
                    }
                }

                $unitOfWork = $this->entityManager->getUnitOfWork();

                if ($unitOfWork->isInIdentityMap($entity)) {
                    $unitOfWork->removeFromIdentityMap($entity);
                }

                $progressBar->display();
                $progressBar->advance();

                continue;
            }

            $this->entityManager->persist($entity);
            $progressBar->advance();

            $imported++;

            if ($input->getOption('no-batch') || $imported % (int)$input->getOption('batch-size') === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();

                gc_collect_cycles();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $event = $stopwatch->stop('import');
        $duration = $event->getDuration();

        $progressBar->clear();

        $message = sprintf('%s elements have been imported in %d ms.', $imported, $duration);
        $this->logger->info($message);
        $io->success($message);

        return self::SUCCESS;
    }

    /**
     * @param string[] $csv
     *
     * @return object
     */
    abstract protected function createOrUpdateEntity(array $csv): object;

    abstract protected function getEntityClassName(): string;
}
