<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Aircraft;
use App\Entity\AircraftPicture;
use App\Factory\AircraftPictureFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAircraftPictures extends AbstractImportCommand
{
    public function __construct(
        protected AircraftPictureFactoryInterface $aircraftPictureFactory,
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
            ->setName('import:aircraft-pictures')
            ->setDescription('Import aircraft pictures from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $filename = sprintf('%s/%s', $this->workingDirectory, $csv['picture']);

        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('File "%s" not found or not readable.', $filename));
        }

        $aircraft = $this->entityManager
            ->getRepository(Aircraft::class)
            ->findOneBy(['icao24bitAddress' => $csv['aircraft']]);

        $aircraftPicture = $this->entityManager
            ->getRepository(AircraftPicture::class)
            ->findOneBy(
                [
                    'aircraft' => $aircraft,
                    'name' => basename($filename),
                ]
            );

        $aircraftPicture ??= new AircraftPicture();
        $aircraftPicture->update($this->aircraftPictureFactory->createFromCsv($csv));

        if ($aircraftPicture->getChecksum() !== sha1_file($filename)) {
            $aircraftPicture->setLocalFile(new File($filename));
        }

        return $aircraftPicture;
    }

    protected function getEntityClassName(): string
    {
        return AircraftPicture::class;
    }
}
