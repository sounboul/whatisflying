<?php

declare(strict_types=1);

namespace App\Traits;

trait CsvParserTrait
{
    /**
     * Parses and validates a value from a CSV file as an array.
     *
     * @param string $value The value to parse.
     *
     * @return string[]|null The value as an array, or null if the validation failed.
     */
    protected function parseArray(string $value): ?array
    {
        if (null !== ($value = $this->parseString($value))) {
            return explode(';', $value);
        }

        return null;
    }

    /**
     * Parses and validates a value from a CSV file as a boolean.
     *
     * The following value are considered to be true: "1", "on" and "true".
     * The following value are considered to be false: "0", "off" and "false".
     *
     * @param string $value The value to parse.
     *
     * @return bool|null The value as a boolean, or null if the validation failed.
     */
    protected function parseBool(string $value): ?bool
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN,
            [
                'flags' => FILTER_NULL_ON_FAILURE,
                'options' => [
                    'default' => null,
                ],
            ]
        );
    }

    /**
     * Parses and validates a value from a CSV file as a floating point number.
     *
     * @param string $value The value to parse.
     *
     * @return float|null The value as a floating point number, or null if the validation failed.
     */
    protected function parseFloat(string $value): ?float
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_FLOAT,
            [
                'options' => [
                    'decimal' => '.',
                    'default' => null,
                ],
            ]
        );
    }

    /**
     * Parses and validates a value from a CSV file as an integer.
     *
     * @param string $value The value to parse.
     *
     * @return int|null The value as an integer, or null if the validation failed.
     */
    protected function parseInt(string $value): ?int
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'default' => null,
                ],
            ]
        );
    }

    /**
     * Parses and validates a value from a CSV file as a string.
     *
     * @param string $value The value to parse.
     *
     * @return string|null The value as a string, or null if the validation failed.
     */
    protected function parseString(string $value): ?string
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_REGEXP,
            [
                'options' => [
                    'default' => null,
                    'regexp' => '/^(?![\t\s])(.+)$/i',
                ],
            ]
        );
    }
}
