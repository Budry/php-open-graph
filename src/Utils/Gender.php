<?php

namespace Budry\OpenGraph\Utils;

class Gender
{
    const FEMALE = "female";
    const MALE = "male";

    /**
     * @return string[]
     */
    public static function getAllowedValues(): array
    {
        return [self::MALE, self::FEMALE];
    }
}