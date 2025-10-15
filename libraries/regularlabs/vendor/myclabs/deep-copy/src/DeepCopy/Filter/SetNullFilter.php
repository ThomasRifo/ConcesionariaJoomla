<?php

namespace RegularLabs\Scoped\DeepCopy\Filter;

use RegularLabs\Scoped\DeepCopy\Reflection\ReflectionHelper;
/**
 * @final
 */
class SetNullFilter implements Filter
{
    /**
     * Sets the object property to null.
     *
     * {@inheritdoc}
     */
    public function apply($object, $property, $objectCopier)
    {
        $reflectionProperty = ReflectionHelper::getProperty($object, $property);
        if (\PHP_VERSION_ID < 80100) {
            $reflectionProperty->setAccessible(\true);
        }
        $reflectionProperty->setValue($object, null);
    }
}
