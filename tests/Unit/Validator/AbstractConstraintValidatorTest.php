<?php

declare(strict_types=1);

namespace Tests\Unit\Validator;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

abstract class AbstractConstraintValidatorTest extends TestCase
{
    protected ConstraintValidatorInterface $validator;

    protected function expectValidationError(string $message): void
    {
        $builder = $this->getConstraintViolationBuilderMock();
        $builder
            ->expects(static::once())
            ->method('addViolation');

        $context = $this->getExecutionContextMock();
        $context
            ->expects(static::once())
            ->method('buildViolation')
            ->with(static::equalTo($message))
            ->will(static::returnValue($builder));

        $this->validator->initialize($context);
    }

    protected function expectNoValidationError(): void
    {
        $context = $this->getExecutionContextMock();
        $context
            ->expects(static::never())
            ->method('buildViolation');

        $this->validator->initialize($context);
    }

    protected function getConstraintViolationBuilderMock(): MockObject|ConstraintViolationBuilder
    {
        return $this
            ->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['addViolation'])
            ->getMock();
    }

    protected function getExecutionContextMock(): MockObject|ExecutionContext
    {
        return $this
            ->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['buildViolation'])
            ->getMock();
    }

    protected function getValidator(string $class): ConstraintValidatorInterface
    {
        $this->validator = new $class();

        return $this->validator;
    }
}
