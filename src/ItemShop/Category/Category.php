<?php


namespace App\ItemShop\Category;


class Category {

    protected $id;

    protected $name;

    protected $trailer;

    protected $description;

    protected $linkSegment;

    public function __construct(
        int $id,
        string $name,
        string $trailer,
        string $description,
        string $linkSegment
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->trailer = $trailer;
        $this->description = $description;
        $this->linkSegment = $linkSegment;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getTrailer(): string {
        return $this->trailer;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getLinkSegment(): string {
        return $this->linkSegment;
    }

}

