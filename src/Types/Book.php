<?php

namespace Budry\OpenGraph\Types;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\OpenGraph;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Isbn\Isbn;
use Respect\Validation\Validator;

class Book implements TypeInterface
{
    /** @var string[] */
    private $authors = [];

    /** @var string|null */
    private $isbn;

    /** @var \DateTimeImmutable|null */
    private $releaseDate;

    /** @var string[] */
    private $tags = [];

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function addAuthor(string $author): self
    {
        if (!Validator::url()->validate($author)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }

        $this->authors[] = $author;
        return $this;
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
     * @return string|null
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    /**
     * @param string|null $isbn
     * @return $this
     */
    public function setIsbn(?string $isbn): self
    {
        $isbnValidator = new Isbn();
        if ($isbn && !$isbnValidator->validation->isbn($isbn)) {
            throw new \InvalidArgumentException("Invalid ISBN format");
        }

        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTimeImmutable|null $releaseDate
     * @return $this
     */
    public function setReleaseDate(?\DateTimeImmutable $releaseDate): self
    {
        $this->releaseDate = $releaseDate;
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
     * @return string
     */
    public static function getType(): string
    {
        return "book";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("book:isbn", $this->getIsbn()),
            new MetaItem("book:release_date", $this->getReleaseDate() ? $this->getReleaseDate()->format(OpenGraph::DATE_TIME_FORMAT) : null),
        ];
        foreach ($this->getTags() as $tag) {
            $fields[] = new MetaItem("book:tag", $tag);
        }
        foreach ($this->getAuthors() as $author) {
            $fields[] = new MetaItem("book:author", $author);
        }

        return FieldsFilter::getFilteredItems($fields);
    }


}