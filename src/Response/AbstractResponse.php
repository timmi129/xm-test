<?php

declare(strict_types=1);

namespace App\Response;

use JsonSerializable;
use ReflectionClass;
use UnitEnum;

use function is_array;
use function is_object;

abstract class AbstractResponse implements JsonSerializable
{
    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return $this->extractProps($this);
    }

    private function extractProps(object $object): array // TODO придумать другое решение
    {
        $public = [];

        $reflection = new ReflectionClass($object::class);

        foreach ($reflection->getProperties() as $property) {
            //      $property->setAccessible(true);

            $value = $property->getValue($object);
            $name = $property->getName();

            if (is_array($value)) {
                $public[$name] = [];

                foreach ($value as $item) {
                    if (is_object($item)) {
                        $itemArray = $this->extractProps($item);
                        $public[$name][] = $itemArray;
                    } else {
                        $public[$name][] = $item;
                    }
                }
            } elseif (is_object($value)) {
                if (method_exists($value, 'toString')) {
                    $public[$name] = $value->toString();
                } elseif (method_exists($value, 'getValue')) {
                    $public[$name] = $value->getValue();
                } elseif ($value instanceof UnitEnum) {
                    $public[$name] = $value->value;
                } else {
                    $public[$name] = $this->extractProps($value);
                }
            } else {
                $public[$name] = $value;
            }
        }

        return $public;
    }
}
