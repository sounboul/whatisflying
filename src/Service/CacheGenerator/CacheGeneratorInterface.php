<?php

declare(strict_types=1);

namespace App\Service\CacheGenerator;

interface CacheGeneratorInterface
{
    /**
     * Generates the application cache.
     */
    public function generateCache(): void;
}
