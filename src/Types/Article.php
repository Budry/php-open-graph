<?php

namespace Budry\OpenGraph\Types;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\OpenGraph;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class Article implements TypeInterface
{
    /** @var \DateTimeInterface|null */
    private $publishedDate;

    /** @var \DateTimeInterface|null */
    private $modifiedDate;

    /** @var \DateTimeInterface|null */
    private $expirationDate;

    /** @var string[] */
    private $authors = [];

    /** @var string|null */
    private $section;

    /** @var string[] */
    private $tags = [];

    /**
     * @return \DateTimeInterface|null
     */
    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->publishedDate;
    }

    /**
     * @param \DateTimeInterface|null $publishedDate
     * @return $this
     */
    public function setPublishedDate(?\DateTimeInterface $publishedDate): self
    {
        $this->publishedDate = $publishedDate;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modifiedDate;
    }

    /**
     * @param \DateTimeInterface|null $modifiedDate
     * @return $this
     */
    public function setModifiedDate(?\DateTimeInterface $modifiedDate): self
    {
        $this->modifiedDate = $modifiedDate;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTimeInterface|null $expirationDate
     * @return $this
     */
    public function setExpirationDate(?\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param string $profile
     * @return $this
     */
    public function addAuthor(string $profile): self
    {
        if (!Validator::url()->validate($profile)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->authors[] = $profile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSection(): ?string
    {
        return $this->section;
    }

    /**
     * @param string|null $section
     * @return $this
     */
    public function setSection(?string $section): self
    {
        $this->section = $section;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return "article";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("article:published_time", $this->getPublishedDate() ? $this->getPublishedDate()->format(OpenGraph::DATE_TIME_FORMAT) : null),
            new MetaItem("article:modified_time", $this->getModifiedDate() ? $this->getModifiedDate()->format(OpenGraph::DATE_TIME_FORMAT) : null),
            new MetaItem("article:expiration_time", $this->getExpirationDate() ? $this->getExpirationDate()->format(OpenGraph::DATE_TIME_FORMAT) : null),
            new MetaItem("article:section", $this->getSection()),
        ];
        foreach ($this->getTags() as $tag) {
            $fields[] = new MetaItem("article:tag", $tag);
        }
        foreach ($this->getAuthors() as $author) {
            $fields[] = new MetaItem("article:author", $author);
        }

        return FieldsFilter::getFilteredItems($fields);
    }
}