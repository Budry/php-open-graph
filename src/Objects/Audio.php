<?php

namespace Budry\OpenGraph\Objects;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\ObjectInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class Audio implements ObjectInterface
{
    /** @var string */
    private $url;

    /** @var string|null */
    private $secureUrl;

    /** @var string|null */
    private $type;

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
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        return FieldsFilter::getFilteredItems([
            new MetaItem("og:audio", $this->getUrl()),
            new MetaItem("og:audio:secure_url", $this->getSecureUrl()),
            new MetaItem("og:audio:type", $this->getType()),
        ]);
    }
}