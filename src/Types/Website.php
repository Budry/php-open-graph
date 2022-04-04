<?php

namespace Budry\OpenGraph\Types;

use Budry\OpenGraph\TypeInterface;

class Website implements TypeInterface
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return "website";
    }

    /**
     * @return array|\Budry\OpenGraph\MetaItem[]
     */
    public function getFields(): array
    {
        return [];
    }
}