<?php


namespace App\ItemShop\Product;


class Tag {

    protected $id;

    protected $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

}