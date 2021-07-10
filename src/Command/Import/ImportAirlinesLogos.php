<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airline;
use App\Entity\AirlineLogo;
use App\Factory\AirlineLogoFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirlinesLogos extends AbstractImportCommand
{
    public function __construct(
        protected AirlineLogoFactoryInterface $airlineLogoFactory,
        protected EntityManagerInterface $entityManager,
        protected LoggerInterface $logger,
        protected ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import:airlines-logos')
            ->setDescription('Import airlines logos from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $filename = sprintf('%s/%s', $this->workingDirectory, $csv['logo']);

        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('File "%s" not found or not readable.', $filename));
        }

        $airline = $this->entityManager
            ->getRepository(Airline::class)
            ->findOneBy(['icaoCode' => $csv['airline']]);

        $airlineLogo = $this->entityManager
            ->getRepository(AirlineLogo::class)
            ->findOneBy(['airline' => $airline]);

        $airlineLogo ??= new AirlineLogo();
        $airlineLogo->update($this->airlineLogoFactory->createFromCsv($csv));

        if ($airlineLogo->getChecksum() !== sha1_file($filename)) {
            $airlineLogo->setLocalFile(new File($filename));
        }

        return $airlineLogo;
    }

    protected function getEntityClassName(): string
    {
        return AirlineLogo::class;
    }
}
