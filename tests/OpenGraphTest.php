<?php

class OpenGraphTest extends \PHPUnit\Framework\TestCase
{
    public function testRequired()
    {
        $imageUrl = "https://example.com/image.jpg";
        $pageTitle = "Page title";
        $url = "https://example.com";

        $image = new \Budry\OpenGraph\Objects\Image($imageUrl);
        $openGraph = new \Budry\OpenGraph\OpenGraph($pageTitle, $url, $image);

        $fields = $openGraph->getFields();
        $expected = [
            new \Budry\OpenGraph\MetaItem("og:title", $pageTitle),
            new \Budry\OpenGraph\MetaItem("og:url", $url),
            new \Budry\OpenGraph\MetaItem("og:image", $imageUrl),
            new \Budry\OpenGraph\MetaItem("og:type", "website"),
        ];
        $this->assertEqualsCanonicalizing($fields, $expected);
    }

    public function testUrlValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        new \Budry\OpenGraph\Objects\Image("test");
    }

    public function testImages()
    {
        $imageUrl = "https://example.com/image.jpg";
        $pageTitle = "Page title";
        $url = "https://example.com";

        $image = new \Budry\OpenGraph\Objects\Image($imageUrl);

        $imageUrl2 = "https://examples.com";
        $image2 = new \Budry\OpenGraph\Objects\Image($imageUrl2);

        $openGraph = new \Budry\OpenGraph\OpenGraph($pageTitle, $url, $image);
        $openGraph->addImage($image2);

        $fields = $openGraph->getFields();
        $this->assertEquals(new \Budry\OpenGraph\MetaItem("og:image", $imageUrl), $fields[3]);
        $this->assertEquals(new \Budry\OpenGraph\MetaItem("og:image", $imageUrl2), $fields[4]);
    }

    public function testType()
    {
        $imageUrl = "https://example.com/image.jpg";
        $pageTitle = "Page title";
        $url = "https://example.com";

        $openGraph = new Budry\OpenGraph\OpenGraph($pageTitle, $url, new \Budry\OpenGraph\Objects\Image($imageUrl));

        $article = new \Budry\OpenGraph\Types\Article();

        $date = new DateTimeImmutable();

        $article->addTag("tag1")
            ->addTag("tag2")
            ->setExpirationDate($date);
        $openGraph->setType($article);

        $fields = $openGraph->getFields();

        $expected = [
            new \Budry\OpenGraph\MetaItem("og:title", $pageTitle),
            new \Budry\OpenGraph\MetaItem("og:url", $url),
            new \Budry\OpenGraph\MetaItem("og:image", $imageUrl),
            new \Budry\OpenGraph\MetaItem("og:type", "article"),
            new \Budry\OpenGraph\MetaItem("article:tag", "tag1"),
            new \Budry\OpenGraph\MetaItem("article:tag", "tag2"),
            new \Budry\OpenGraph\MetaItem("article:expiration_time", $date->format(\Budry\OpenGraph\OpenGraph::DATE_TIME_FORMAT)),
        ];

        $this->assertEqualsCanonicalizing($expected, $fields);
    }
}