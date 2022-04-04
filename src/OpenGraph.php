<?php

namespace Budry\OpenGraph;

use Budry\OpenGraph\Objects\Audio;
use Budry\OpenGraph\Objects\Image;
use Budry\OpenGraph\Objects\Video;
use Budry\OpenGraph\Types\Website;
use Respect\Validation\Validator;

class OpenGraph implements ObjectInterface
{
    const DATE_TIME_FORMAT = "Y-m-d\TH:i:sO";

    /** @var string */
    private $title;

    /** @var string */
    private $url;

    /** @var TypeInterface */
    private $type;

    /** @var Audio[] */
    private $audios = [];

    /** @var Video[] */
    private $videos = [];

    /** @var Image[] */
    private $images = [];

    /**
     * @param string $title
     * @param string $url
     * @param Image $image
     * @param TypeInterface|null $type
     */
    public function __construct(string $title, string $url, Image $image, ?TypeInterface $type = null)
    {
        if (!Validator::url()->validate($url)) {
            throw new \InvalidArgumentException("URL is not in valid format");
        }
        $this->title = $title;
        $this->url = $url;
        $this->images[] = $image;
        $this->type = $type ?? new Website();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Audio[]
     */
    public function getAudios(): array
    {
        return $this->audios;
    }

    /**
     * @return Video[]
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param TypeInterface $type
     * @return $this
     */
    public function setType(TypeInterface $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param Video $video
     * @return $this
     */
    public function addVideo(Video $video): self
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * @param Audio $video
     * @return $this
     */
    public function addAudio(Audio $video): self
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * @param Image $video
     * @return $this
     */
    public function addImage(Image $video): self
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        $fields = [
            new MetaItem("og:title", $this->getTitle()),
            new MetaItem("og:type", $this->getType()::getType()),
            new MetaItem("og:url", $this->getUrl()),
        ];
        foreach ($this->getImages() as $image) {
            $fields = array_merge($fields, $image->getFields());
        }
        foreach ($this->getVideos() as $video) {
            $fields = array_merge($fields, $video->getFields());
        }
        foreach ($this->getAudios() as $audio) {
            $fields = array_merge($fields, $audio->getFields());
        }

        return $fields;
    }
}