<?php


namespace App\News;


class News {

    protected $title;

    protected $authorName;

    protected $pubDate;

    protected $trailer;

    protected $moreLink;

    public function __construct(
        string $title,
        string $authorName,
        \DateTimeImmutable $pubDate,
        string $trailer,
        string $moreLink
    ) {
        $this->title = $title;
        $this->authorName = $authorName;
        $this->pubDate = $pubDate;
        $this->trailer = $trailer;
        $this->moreLink = $moreLink;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthorName(): string {
        return $this->authorName;
    }

    public function getPubDate(): \DateTimeImmutable {
        return $this->pubDate;
    }

    public function getTrailer(): string {
        return $this->trailer;
    }

    public function getMoreLink(): string {
        return $this->moreLink;
    }

}