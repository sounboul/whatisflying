<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Airport;
use App\Entity\Navaid;
use App\Traits\CsvParserTrait;
use Doctrine\ORM\EntityManagerInterface;

final class NavaidFactory implements NavaidFactoryInterface
{
    use CsvParserTrait;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createFromCsv(array $csv): Navaid
    {
        $navaid = new Navaid();

        if (!is_null($airport = $this->parseString($csv['airport']))) {
            $airport = $this->entityManager
                ->getRepository(Airport::class)
                ->findOneBy(['icaoCode' => $airport]);

            $navaid->setAirport($airport);
        }

        if (!is_null($airportRunway = $this->parseString($csv['airport_runway']))) {
            $navaid->setAirportRunway(strtoupper($airportRunway));
        }

        if (!is_null($country = $this->parseString($csv['country']))) {
            $navaid->setCountry(strtoupper($country));
        }

        if (!is_null($dmeBias = $this->parseFloat($csv['dme_bias']))) {
            $navaid->setDmeBias(round($dmeBias, 2));
        }

        if (!is_null($dmeChannel = $this->parseString($csv['dme_channel']))) {
            $navaid->setDmeChannel(strtoupper($dmeChannel));
        }

        if (!is_null($dmeRXFrequency = $this->parseInt($csv['dme_rx_frequency']))) {
            $navaid->setDmeRXFrequency($dmeRXFrequency);
        }

        if (!is_null($dmeTXFrequency = $this->parseInt($csv['dme_tx_frequency']))) {
            $navaid->setDmeTXFrequency($dmeTXFrequency);
        }

        if (!is_null($elevation = $this->parseInt($csv['elevation']))) {
            $navaid->setElevation($elevation);
        }

        if (!is_null($frequency = $this->parseInt($csv['frequency']))) {
            $navaid->setFrequency($frequency);
        }

        if (!is_null($glideSlopeAngle = $this->parseFloat($csv['glide_slope_angle']))) {
            $navaid->setGlideSlopeAngle(round($glideSlopeAngle, 2));
        }

        if (!is_null($identifier = $this->parseString($csv['identifier']))) {
            $navaid->setIdentifier(strtoupper($identifier));
        }

        if (!is_null($latitude = $this->parseFloat($csv['latitude']))) {
            $navaid->setLatitude(round($latitude, 5));
        }

        if (!is_null($localizerHeading = $this->parseFloat($csv['localizer_heading']))) {
            $navaid->setLocalizerHeading(round($localizerHeading, 3));
        }

        if (!is_null($longitude = $this->parseFloat($csv['longitude']))) {
            $navaid->setLongitude(round($longitude, 5));
        }

        if (!is_null($name = $this->parseString($csv['name']))) {
            $navaid->setName($name);
        }

        if (!is_null($receptionRange = $this->parseInt($csv['reception_range']))) {
            $navaid->setReceptionRange($receptionRange);
        }

        if (!is_null($region = $this->parseString($csv['region']))) {
            $navaid->setRegion($region);
        }

        if (!is_null($slug = $this->parseString($csv['slug']))) {
            $navaid->setSlug($slug);
        }

        if (!is_null($type = $this->parseString($csv['type']))) {
            $navaid->setType(strtoupper($type));
        }

        if (!is_null($usage = $this->parseString($csv['usage']))) {
            $navaid->setUsage(strtoupper($usage));
        }

        if (!is_null($vorSlavedVariation = $this->parseFloat($csv['vor_slaved_variation']))) {
            $navaid->setVorSlavedVariation(round($vorSlavedVariation, 3));
        }

        return $navaid;
    }
}
