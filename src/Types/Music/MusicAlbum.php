<?php

namespace Budry\OpenGraph\Types\Music;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\OpenGraph;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class MusicAlbum implements TypeInterface
{
    /** @var array<array{song: string, disc: int|null, track: int|null}> */
    private $songs = [];

    /** @var string|null */
    private $musician;

    /** @var \DateTimeInterface|null */
    public $releasedDate;

    /**
     * @return array<array{song: string, disc: int|null, track: int|null}>
     */
    public function getSongs(): array
    {
        return $this->songs;
    }

    /**
     * @param string $song
     * @param int|null $disc
     * @param int|null $track
     * @return $this
     */
    public function addSong(string $song, ?int $disc, ?int $track): self
    {
        if (!Validator::url()->validate($song)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        if ($disc !== null && $disc < 1) {
            throw new \InvalidArgumentException("Disc must be higher then 0");
        }
        if ($track !== null && $track < 1) {
            throw new \InvalidArgumentException("Track must be higher then 0");
        }

        $this->songs[] = [
            'song' => $song,
            'disc' => $disc,
            'track' => $track
        ];
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMusician(): ?string
    {
        return $this->musician;
    }

    /**
     * @param string|null $musician
     * @return $this
     */
    public function setMusician(?string $musician): self
    {
        $this->musician = $musician;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getReleasedDate(): ?\DateTimeInterface
    {
        return $this->releasedDate;
    }

    /**
     * @param \DateTimeInterface|null $releasedDate
     * @return $this
     */
    public function setReleasedDate(?\DateTimeInterface $releasedDate): self
    {
        $this->releasedDate = $releasedDate;
        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return "music.album";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("music:release_date", $this->getReleasedDate() ? $this->getReleasedDate()->format(OpenGraph::DATE_TIME_FORMAT) : null),
            new MetaItem("music:musician", $this->getMusician()),
        ];
        foreach ($this->getSongs() as $song) {
            $fields[] = new MetaItem("music:song", $song['song']);
            $fields[] = new MetaItem("music:song:disc", $song['disc'] !== null ? (string)$song["disc"] : null);
            $fields[] = new MetaItem("music:song:track", $song['track'] !== null ? (string)$song["track"] : null);

        }

        return FieldsFilter::getFilteredItems($fields);
    }
}