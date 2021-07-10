<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\AircraftType;
use App\Entity\AircraftTypePicture;
use App\Factory\AircraftTypePictureFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAircraftTypesPictures extends AbstractImportCommand
{
    public function __construct(
        protected AircraftTypePictureFactoryInterface $aircraftTypePictureFactory,
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
            ->setName('import:aircraft-types-pictures')
            ->setDescription('Import aircraft types pictures from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $filename = sprintf('%s/%s', $this->workingDirectory, $csv['picture']);

        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('File "%s" not found or not readable.', $filename));
        }

        $aircraftType = $this->entityManager
            ->getRepository(AircraftType::class)
            ->findOneBy(['icaoCode' => $csv['aircraft_type']]);

        $aircraftTypePicture = $this->entityManager
            ->getRepository(AircraftTypePicture::class)
            ->findOneBy(
                [
                    'aircraftType' => $aircraftType,
                    'name' => basename($filename),
                ]
            );

        $aircraftTypePicture ??= new AircraftTypePicture();
        $aircraftTypePicture->update($this->aircraftTypePictureFactory->createFromCsv($csv));

        if ($aircraftTypePicture->getChecksum() !== sha1_file($filename)) {
            $aircraftTypePicture->setLocalFile(new File($filename));
        }

        return $aircraftTypePicture;
    }

    protected function getEntityClassName(): string
    {
        return AircraftTypePicture::class;
    }
}
