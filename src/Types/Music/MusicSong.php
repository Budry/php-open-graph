<?php

namespace Budry\OpenGraph\Types\Music;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class MusicSong implements TypeInterface
{
    /** @var int|null */
    private $duration;

    /** @var array<array{album: string, disc: int|null, track: int|null}> */
    private $albums = [];

    /** @var string[] */
    private $musicians = [];

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
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return array<array{album: string, disc: int|null, track: int|null}>
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    /**
     * @param string $album
     * @param int|null $disc
     * @param int|null $track
     * @return $this
     */
    public function addAlbum(string $album, ?int $disc, ?int $track): self
    {
        if (!Validator::url()->validate($album)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        if ($disc !== null && $disc < 1) {
            throw new \InvalidArgumentException("Disc must be higher then 0");
        }
        if ($track !== null && $track < 1) {
            throw new \InvalidArgumentException("Track must be higher then 0");
        }

        $this->albums[] = [
            'album' => $album,
            'disc' => $disc,
            'track' => $track
        ];
        return $this;
    }

    /**
     * @return string[]
     */
    public function getMusicians(): array
    {
        return $this->musicians;
    }

    /**
     * @param string $profile
     * @return $this
     */
    public function addMusician(string $profile): self
    {
        if (!Validator::url()->validate($profile)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->musicians[] = $profile;
        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return "music.song";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("music:duration", $this->getDuration() ? (string)$this->getDuration() : null),
        ];
        foreach ($this->getMusicians() as $musician) {
            $fields[] = new MetaItem("music:musician", $musician);
        }
        foreach ($this->getAlbums() as $album) {
            $fields[] = new MetaItem("music:album", $album['album']);
            $fields[] = new MetaItem("music:album:disc", $album['disc'] !== null ? (string)$album['disc'] : null);
            $fields[] = new MetaItem("music:album:track", $album['track'] !== null ? (string)$album['track'] : null);
        }

        return FieldsFilter::getFilteredItems($fields);
    }
}