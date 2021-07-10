<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Airline;
use App\Entity\AirlinePicture;
use App\Factory\AirlinePictureFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportAirlinesPictures extends AbstractImportCommand
{
    public function __construct(
        protected AirlinePictureFactoryInterface $airlinePictureFactory,
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
            ->setName('import:airlines-pictures')
            ->setDescription('Import airlines pictures from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $filename = sprintf('%s/%s', $this->workingDirectory, $csv['picture']);

        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('File "%s" not found or not readable.', $filename));
        }

        $airline = $this->entityManager
            ->getRepository(Airline::class)
            ->findOneBy(['icaoCode' => $csv['airline']]);

        $airlinePicture = $this->entityManager
            ->getRepository(AirlinePicture::class)
            ->findOneBy(
                [
                    'airline' => $airline,
                    'name' => basename($filename),
                ]
            );

        $airlinePicture ??= new AirlinePicture();
        $airlinePicture->update($this->airlinePictureFactory->createFromCsv($csv));

        if ($airlinePicture->getChecksum() !== sha1_file($filename)) {
            $airlinePicture->setLocalFile(new File($filename));
        }

        return $airlinePicture;
    }

    protected function getEntityClassName(): string
    {
        return AirlinePicture::class;
    }
}
