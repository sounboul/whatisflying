<?php

declare(strict_types=1);

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class DateTimeUTCType extends Type
{
    public const NAME = 'datetime_utc';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof \DateTime) {
            $timezone = new \DateTimeZone('UTC');
            $value->setTimezone($timezone);

            return $value->format($platform->getDateTimeFormatString());
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            DateTimeUTCType::NAME,
            [
                'null',
                \DateTime::class,
            ]
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTime
    {
        if (is_null($value) || $value instanceof \DateTime) {
            return $value;
        }

        $timezone = new \DateTimeZone('UTC');
        $datetime = \DateTime::createFromFormat($platform->getDateTimeFormatString(), $value, $timezone);

        if (false === $datetime) {
            throw ConversionException::conversionFailedFormat(
                $value,
                DateTimeUTCType::NAME,
                $platform->getDateTimeFormatString()
            );
        }

        return $datetime;
    }

    public function getName(): string
    {
        return DateTimeUTCType::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return sprintf(
            '%s COMMENT \'(DC2Type:%s)\'',
            $platform->getDateTimeTypeDeclarationSQL($column),
            DateTimeUTCType::NAME
        );
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
