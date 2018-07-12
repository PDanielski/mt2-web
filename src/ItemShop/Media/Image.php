<?php


namespace App\ItemShop\Media;


class Image implements Hrefable {

    protected $id;

    protected $name;

    protected $href;

    public function __construct(int $id, string $name, string $href) {
        $this->id = $id;
        $this->name = $name;
        $this->href = $href;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getHref(): string {
        return $this->href;
    }

}