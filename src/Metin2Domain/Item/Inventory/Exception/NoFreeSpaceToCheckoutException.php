<?php


namespace App\Metin2Domain\Item\Inventory\Exception;

class NoFreeSpaceToCheckoutException extends \Exception {

    protected $itemSize;

    public function __construct(int $itemSize) {
        $this->itemSize = $itemSize;

        $message = "There is not a known free space for an item with size {$itemSize}";
        parent::__construct($message);
    }

    public function getItemSize(): int {
        return $this->itemSize;
    }

}