<?php

declare(strict_types=1);

namespace App\Service\CacheGenerator;

use App\Entity\Aircraft;
use App\Repository\AircraftRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

final class CacheGenerator implements CacheGeneratorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private string $cacheDirectory
    ) {
    }

    public function generateCache(): void
    {
        $this->generateAircraftCache();
    }

    private function generateAircraftCache(): void
    {
        $writer = Writer::createFromPath($this->cacheDirectory . '/aircraft.csv', 'w');

        /** @var AircraftRepository $repository */
        $repository = $this->entityManager->getRepository(Aircraft::class);
        $aircrafts = $repository->findAllCacheableProperties();

        foreach ($aircrafts as $aircraft) {
            try {
                $writer->insertOne(
                    [
                        $aircraft->getIcao24bitAddress(),
                        $aircraft->getAircraftType()?->getIcaoCode(),
                        $aircraft->getDescription(),
                    ]
                );
            } catch (CannotInsertRecord $exception) {
                throw new \Exception($exception->getMessage(), $exception->getCode(), $exception);
            }
        }
    }
}
