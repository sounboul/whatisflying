<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftPicture;

interface AircraftPictureFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AircraftPicture
     */
    public function createFromCsv(array $csv): AircraftPicture;
}
