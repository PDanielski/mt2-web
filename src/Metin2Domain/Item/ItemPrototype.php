<?php


namespace App\Metin2Domain\Item;


final class ItemPrototype {

    protected $itemVnum;

    protected $size;

    public function __construct(int $itemVnum, int $size) {
        $this->itemVnum = $itemVnum;
        $this->size = $size;
    }

    public function getItemVnum(): int {
        return $this->itemVnum;
    }

    public function getItemSize(): int {
        return $this->size;
    }

}