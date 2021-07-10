<?php

declare(strict_types=1);

namespace Tests\Unit\Traits;

use App\Traits\CsvParserTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Traits\CsvParserTrait
 */
final class CsvParserTraitTest extends TestCase
{
    /**
     * @testdox Method parseArray() returns an array when a valid value is provided.
     */
    public function testParseArrayReturnArrayOnValidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseArray', ''));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseArray', '  first;second'));
    }

    /**
     * @testdox Method parseArray() returns null when an invalid value is provided.
     */
    public function testParseArrayReturnNullOnInvalidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(['first', 'second'], $this->callProtectedMethod($csvParser, 'parseArray', 'first;second'));
    }

    /**
     * @testdox Method parseBool() returns false when a valid falsy value is provided.
     */
    public function testParseBoolReturnFalseOnFalsyValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(false, $this->callProtectedMethod($csvParser, 'parseBool', '0'));
        self::assertEquals(false, $this->callProtectedMethod($csvParser, 'parseBool', 'off'));
        self::assertEquals(false, $this->callProtectedMethod($csvParser, 'parseBool', 'false'));
    }

    /**
     * @testdox Method parseBool() returns true when a valid truthy value is provided.
     */
    public function testParseBoolReturnTrueOnTruthyValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(true, $this->callProtectedMethod($csvParser, 'parseBool', '1'));
        self::assertEquals(true, $this->callProtectedMethod($csvParser, 'parseBool', 'on'));
        self::assertEquals(true, $this->callProtectedMethod($csvParser, 'parseBool', 'true'));
    }

    /**
     * @testdox Method parseBool() returns null when an invalid value is provided.
     */
    public function testParseBoolReturnNullOnInvalidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseBool', ''));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseBool', '3'));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseBool', '1.25'));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseBool', 'helium'));
    }

    /**
     * @testdox Method parseFloat() returns a float when a valid value is provided.
     */
    public function testParseFloatReturnFloatOnValidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(175.3174, $this->callProtectedMethod($csvParser, 'parseFloat', '175.3174'));
    }

    /**
     * @testdox Method parseFloat() returns null when an invalid value is provided.
     */
    public function testParseFloatReturnNullOnInvalidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseFloat', ''));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseFloat', '8,5'));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseFloat', 'whale'));
    }

    /**
     * @testdox Method parseInt() returns an integer when a valid value is provided.
     */
    public function testParseIntReturnIntOnValidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(15, $this->callProtectedMethod($csvParser, 'parseInt', '15'));
    }

    /**
     * @testdox Method parseInt() returns null when an invalid value is provided.
     */
    public function testParseIntReturnNullOnInvalidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseInt', ''));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseInt', '6  84'));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseInt', '6.301'));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseInt', 'dishwasher'));
    }

    /**
     * @testdox Method parseString() returns a string when a valid value is provided.
     */
    public function testParseStringReturnStringOnValidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals('A valid string', $this->callProtectedMethod($csvParser, 'parseString', 'A valid string'));
    }

    /**
     * @testdox Method parseString() returns null when an invalid value is provided.
     */
    public function testParseStringReturnNullOnInvalidValue(): void
    {
        $csvParser = $this->getMockForTrait(CsvParserTrait::class);

        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseString', ''));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseString', '	Leading tab'));
        self::assertEquals(null, $this->callProtectedMethod($csvParser, 'parseString', ' Leading space'));
    }

    private function callProtectedMethod(object $object, string $method, mixed...$args): mixed
    {
        try {
            $reflectionMethod = new \ReflectionMethod($object, $method);
        } catch (\ReflectionException $exception) {
            self::fail($exception->getMessage());
        }

        $reflectionMethod->setAccessible(true);

        try {
            return $reflectionMethod->invoke($object, ...$args);
        } catch (\ReflectionException $exception) {
            self::fail($exception->getMessage());
        }
    }
}
