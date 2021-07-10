<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftTypePicture;

interface AircraftTypePictureFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AircraftTypePicture
     */
    public function createFromCsv(array $csv): AircraftTypePicture;
}
