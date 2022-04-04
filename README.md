# PHP The Open Graph protocol

Simple object generator for open graph protocol. Full implementation of [this specification](https://ogp.me/)

## Installation

The best way to install `budry/php-open-grap` is using [Composer](https://getcomposer.org/)

```shell
$ composer require budry/php-open-grap
```

## How to use

Create open graph instance and configure

```php
$image = new \Budry\OpenGraph\Objects\Image("https://example.com/image.jpg");
$openGraph = new \Budry\OpenGraph\OpenGraph("Page title", "Page URL", $image);

$article = new \Budry\OpenGraph\Types\Article();
$article->setExpirationDate(new DateTimeImmutable("2022-03-12 12:23:24"))
    ->setModifiedDate(new DateTimeImmutable())
    ->setPublishedDate(new DateTimeImmutable())
    ->setSection("SCI-FI")
$openGraph->setType($article);

foreach ($openGraph->getFields() as $field) {
    echo '<meta property="' . $field->getName() . '" content="' . $field->getContent() . '">'
}
```