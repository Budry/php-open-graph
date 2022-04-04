<?php

namespace Budry\OpenGraph;

interface TypeInterface extends ObjectInterface
{
    /**
     * @return string
     */
    public static function getType(): string;
}