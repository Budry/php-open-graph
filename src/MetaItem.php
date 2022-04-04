<?php

namespace Budry\OpenGraph;

class MetaItem
{
    /** @var string */
    private $name;

    /** @var string|null */
    private $content;

    /**
     * @param string $name
     * @param string|null $content
     */
    public function __construct(string $name, ?string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
}