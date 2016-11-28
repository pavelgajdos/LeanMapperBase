<?php

namespace PG\LeanMapper;

use Joseki\LeanMapper\InvalidArgumentException;

abstract class BaseEntity extends \Joseki\LeanMapper\BaseEntity
{
    /** @var string Tag for various internal usage. */
    public $_tag;

    public static function enumValues($propertyName)
    {
        $property = self::getReflection()->getEntityProperty($propertyName);
        if (!$property->containsEnumeration()) {
            throw new InvalidArgumentException;
        }

        $values = array();
        foreach ($property->getEnumValues() as $possibleValue) {
            $values[$possibleValue] = $possibleValue;
        }

        return $values;
    }



    public function equals($another)
    {
        if (is_object($another)
            &&
            $another instanceof $this
            &&
            $another->id == $this->id
        ) {
            return true;
        }
        return false;
    }



    public function __toString()
    {
        return static::class . ":" . $this->id;
    }
}