<?php

namespace App\Type;

use App\Enums\InputFormat;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class InputFormatType extends Type
{
    const MYTYPE = 'inputformat';

    public function getName(): string
    {
        return self::MYTYPE;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(255)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof InputFormat) {
            return $value->value;
        }

        return null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return InputFormat::tryFrom($value);
    }
}
