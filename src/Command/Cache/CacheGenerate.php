<?php

declare(strict_types=1);

namespace App\Command\Cache;

use App\Service\CacheGenerator\CacheGeneratorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class CacheGenerate extends Command
{
    public function __construct(
        private CacheGeneratorInterface $cacheGenerator,
        private LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('cache:generate')
            ->setDescription('Generate the application cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->cacheGenerator->generateCache();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $message = 'The application cache has been generated.';
        $this->logger->info($message);
        $io->success($message);

        return self::SUCCESS;
    }
}
