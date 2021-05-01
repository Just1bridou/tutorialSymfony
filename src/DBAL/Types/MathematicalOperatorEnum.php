<?php
namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class MathematicalOperatorEnum extends AbstractEnumType
{
    public const GREATER_THAN = '>';
    public const GREATER_THAN_OR_EQUAL_TO = '>=';
    public const LOWER_THAN = '<';
    public const LOWER_THAN_OR_EQUAL_TO = '<=';
    public const EQUAL = '==';

    protected static $choices = [
        self::GREATER_THAN => '>',
        self::GREATER_THAN_OR_EQUAL_TO => '>=',
        self::LOWER_THAN => '<',
        self::LOWER_THAN_OR_EQUAL_TO => '<=',
        self::EQUAL => '=='
    ];
}