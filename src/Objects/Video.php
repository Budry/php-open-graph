<?php

namespace Budry\OpenGraph\Objects;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\ObjectInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class Video implements ObjectInterface
{
    /** @var string */
    private $url;

    /** @var string|null */
    private $secureUrl;

    /** @var string|null */
    private $type;

    /** @var float|null */
    private $width;

    /** @var float|null */
    private $height;

    /** @var string|null */
    private $alt;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        if (!Validator::url()->validate($url)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getSecureUrl(): ?string
    {
        return $this->secureUrl;
    }

    /**
     * @param string|null $secureUrl
     * @return $this
     */
    public function setSecureUrl(?string $secureUrl): self
    {
        if (!Validator::url()->validate($secureUrl)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->secureUrl = $secureUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getWidth(): ?float
    {
        return $this->width;
    }

    /**
     * @param float|null $width
     * @return $this
     */
    public function setWidth(?float $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @param float|null $height
     * @return $this
     */
    public function setHeight(?float $height): self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlt(): ?string
    {
        return $this->alt;
    }

    /**
     * @param string|null $alt
     * @return $this
     */
    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * @return MetaItem[]
     */
    public function getFields(): array
    {
        return FieldsFilter::getFilteredItems([
            new MetaItem("og:image", $this->getUrl()),
            new MetaItem("og:image:secure_url", $this->getSecureUrl()),
            new MetaItem("og:image:type", $this->getType()),
            new MetaItem("og:image:width", (string)$this->getWidth()),
            new MetaItem("og:image:height", (string)$this->getHeight()),
            new MetaItem("og:image:alt", $this->getAlt())
        ]);
    }
}