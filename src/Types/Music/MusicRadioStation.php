<?php

namespace Budry\OpenGraph\Types\Music;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class MusicRadioStation implements TypeInterface
{
    /** @var string|null */
    private $creator;

    /**
     * @return string|null
     */
    public function getCreator(): ?string
    {
        return $this->creator;
    }

    /**
     * @param string $creator
     * @return $this
     */
    public function setCreator(string $creator): self
    {
        if (!Validator::url()->validate($creator)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return "music.radio_station";
    }

    public function getFields(): array
    {
        $fields = [
            new MetaItem("music:creator", $this->getCreator()),
        ];

        return FieldsFilter::getFilteredItems($fields);
    }
}