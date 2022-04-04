<?php

namespace Budry\OpenGraph\Types\Music;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\FieldsFilter;
use Respect\Validation\Validator;

class MusicPlaylist implements TypeInterface
{
    /** @var array<array{song: string, track: int|null, disc: int|null}> */
    private $songs = [];

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
     * @return array<array{song: string, track: int|null, disc: int|null}>
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
     * @return string
     */
    public static function getType(): string
    {
        return "music.playlist";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("music:creator", $this->getCreator()),
        ];
        foreach ($this->getSongs() as $song) {
            $fields[] = new MetaItem("music:song", $song['song']);
            $fields[] = new MetaItem("music:song:disc", $song['disc'] !== null ? (string)$song['disc'] : null);
            $fields[] = new MetaItem("music:song:track", $song['track'] !== null ? (string)$song['track'] : null);
        }

        return FieldsFilter::getFilteredItems($fields);
    }
}