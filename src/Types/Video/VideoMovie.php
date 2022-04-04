<?php

namespace Budry\OpenGraph\Types\Video;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\OpenGraph;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class VideoMovie implements TypeInterface
{
    /** @var array */
    private $actors = [];

    /** @var string[] */
    private $directors = [];

    /** @var string[] */
    private $writers = [];

    /** @var int|null */
    private $duration;

    /** @var \DateTimeInterface|null */
    private $releaseDate;

    /** @var string[] */
    private $tags = [];

    /**
     * @return array
     */
    public function getActors(): array
    {
        return $this->actors;
    }

    /**
     * @param string $profile
     * @param string|null $role
     * @return $this
     */
    public function addActor(string $profile, ?string $role = null): self
    {
        if (!Validator::url()->validate($profile)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->actors[] = [
            'profile' => $profile,
            'role' => $role
        ];
        return $this;
    }

    /**
     * @return string[]
     */
    public function getDirectors(): array
    {
        return $this->directors;
    }

    /**
     * @param string $profile
     * @return $this
     */
    public function addDirector(string $profile): self
    {
        if (!Validator::url()->validate($profile)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->directors[] = $profile;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getWriters(): array
    {
        return $this->writers;
    }

    /**
     * @param string $profile
     * @return $this
     */
    public function addWriter(string $profile): self
    {
        $this->writers[] = $profile;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int|null $duration
     * @return $this
     */
    public function setDuration(?int $duration): self
    {
        if ($duration < 1) {
            throw new \InvalidArgumentException("Duration must be higher or equal to 1");
        }
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTimeInterface|null $releaseDate
     * @return $this
     */
    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
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
        return "video.movie";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("video:duration", $this->getDuration()),
            new MetaItem("video:release_date", $this->getReleaseDate()->format(OpenGraph::DATE_TIME_FORMAT)),
        ];
        foreach ($this->getTags() as $tag) {
            $fields[] = new MetaItem("video:tag", $tag);
        }
        foreach ($this->getWriters() as $writer) {
            $fields[] = new MetaItem("video:writer", $writer);
        }
        foreach ($this->getDirectors() as $director) {
            $fields[] = new MetaItem("video:director", $director);
        }
        foreach ($this->getActors() as $actor) {
            $fields[] = new MetaItem("video:actor", $actor["profile"]);
            $fields[] = new MetaItem("video:actor:role", $actor["role"]);
        }

        return FieldsFilter::getFilteredItems($fields);
    }
}