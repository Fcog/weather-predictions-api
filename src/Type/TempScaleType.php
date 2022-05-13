<?php

namespace App\Type;

use App\ObjectValue\Celsius;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TempScaleType extends Type
{
    const MYTYPE = 'tempscale';

    public function getName(): string
    {
        return self::MYTYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'INT NOT NULL';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Celsius::fromCelsius($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getCelsius();
    }
}
