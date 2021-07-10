<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AirlinePicture;

interface AirlinePictureFactoryInterface
{
    /**
     * @param string[] $csv
     *
     * @return AirlinePicture
     */
    public function createFromCsv(array $csv): AirlinePicture;
}
