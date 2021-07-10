<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\DBAL\Types;

use App\Doctrine\DBAL\Types\DateTimeUTCType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Doctrine\DBAL\Types\DateTimeUTCType
 */
final class DateTimeUTCTypeTest extends TestCase
{
    private MockObject|AbstractPlatform $platform;

    public function setUp(): void
    {
        $this->platform = $this
            ->getMockBuilder(AbstractPlatform::class)
            ->onlyMethods(['getDateTimeFormatString', 'getDateTimeTypeDeclarationSQL'])
            ->getMockForAbstractClass();

        $this->platform
            ->method('getDateTimeFormatString')
            ->will(self::returnValue('Y-m-d H:i:s.u'));

        $this->platform
            ->method('getDateTimeTypeDeclarationSQL')
            ->will(self::returnValue('DATETIME'));
    }

    /**
     * @testdox Method convertToDatabaseValue() returns the corresponding string.
     */
    public function testConvertToDatabaseValue(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::assertEquals(null, $dateTimeUtc->convertToDatabaseValue(null, $this->platform));
        self::assertEquals(
            '2020-03-17 18:52:01.000000',
            $dateTimeUtc->convertToDatabaseValue(new \DateTime('2020-03-17 18:52:01'), $this->platform)
        );
    }

    /**
     * @testdox Method convertToDatabaseValue() throws when an invalid data type is provided.
     */
    public function testConvertToDatabaseThrowOnInvalidType(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::expectException(ConversionException::class);

        $dateTimeUtc->convertToDatabaseValue(false, $this->platform);
    }

    /**
     * @testdox Method convertToPHPValue() returns the corresponding DateTime object.
     */
    public function testConvertToPhpValue(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::assertEquals(null, $dateTimeUtc->convertToPHPValue(null, $this->platform));

        $phpValue = $dateTimeUtc->convertToPHPValue('2021-10-25 14:52:25.784221', $this->platform);

        self::assertInstanceOf(\DateTime::class, $phpValue);
        self::assertEquals('UTC', $phpValue->getTimezone()->getName());
        self::assertEquals('2021-10-25 14:52:25.784221', $phpValue->format('Y-m-d H:i:s.u'));
    }

    /**
     * @testdox Method convertToPHPValue() throws when the conversion fails.
     */
    public function testConvertToPhpValueThrowOnConversionFail(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::expectException(ConversionException::class);

        $dateTimeUtc->convertToPHPValue('notavalidformat', $this->platform);
    }

    /**
     * @testdox Method getName() returns the type name.
     */
    public function testGetString(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::assertEquals('datetime_utc', $dateTimeUtc->getName());
    }

    /**
     * @testdox Method getSQLDeclaration() returns the SQL declaration.
     */
    public function testGetSQLDeclaration(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::assertEquals(
            'DATETIME COMMENT \'(DC2Type:datetime_utc)\'',
            $dateTimeUtc->getSQLDeclaration([''], $this->platform)
        );
    }

    /**
     * @testdox Method requiresSQLCommentHint() returns true.
     */
    public function testRequiresSQLCommentHint(): void
    {
        $dateTimeUtc = new DateTimeUTCType();

        self::assertEquals(true, $dateTimeUtc->requiresSQLCommentHint($this->platform));
    }
}
