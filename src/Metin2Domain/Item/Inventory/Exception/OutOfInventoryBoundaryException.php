<?php


namespace App\Metin2Domain\Item\Inventory\Exception;

class OutOfInventoryBoundaryException extends \Exception {

    protected $position;

    protected $maxCapacity;

    public function __construct(int $position, int $maxCapacity) {
        $this->position = $position;
        $this->maxCapacity = $maxCapacity;

        $message = "Tried to access to position {$position}, but the maximum capacity is {$maxCapacity}";
        parent::__construct($message);
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function getMaxCapacity(): int {
        return $this->maxCapacity;
    }

}