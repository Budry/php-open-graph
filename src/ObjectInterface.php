<?php

namespace Budry\OpenGraph;

interface ObjectInterface
{
    /**
     * @return MetaItem[]
     */
    public function getFields(): array;
}