<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Attributes\Updatable;

trait UpdatableTrait
{
    public function update(object $entity): void
    {
        $source = new \ReflectionClass($entity);
        $target = new \ReflectionClass($this);

        if (!$target->isInstance($entity)) {
            throw new \LogicException(
                sprintf(
                    'An instance of "%s" was expected but an instance of "%s" was provided.',
                    get_class($this),
                    get_class($entity)
                )
            );
        }

        foreach ($source->getProperties() as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            if ($sourceProperty->isInitialized($entity)) {
                $attributes = $sourceProperty->getAttributes(Updatable::class);
                foreach ($attributes as $attribute) {
                    if ($attribute->getName() === Updatable::class) {
                        $targetProperty = $target->getProperty($sourceProperty->getName());
                        $targetProperty->setAccessible(true);
                        $targetProperty->setValue($this, $sourceProperty->getValue($entity));
                    }
                }
            }
        }
    }
}
