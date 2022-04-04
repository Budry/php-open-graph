<?php

namespace Budry\OpenGraph\Utils;

use Budry\OpenGraph\MetaItem;

class FieldsFilter
{
    /**
     * @param MetaItem[] $items
     * @return MetaItem[]
     */
    public static function getFilteredItems(array $items): array
    {
        return array_filter($items, function (MetaItem $metaItem) {
            return ($metaItem->getContent() !== null);
        });
    }
}