<?php


namespace App\Item\Event;


use App\Item\Request\SendItemRequest;
use App\Metin2Domain\Item\Inventory\Inventory;
use Symfony\Component\EventDispatcher\Event;

class ItemSentEvent extends Event {

    protected $request;

    protected $inventory;

    public function __construct(SendItemRequest $request, Inventory $inventory) {
        $this->request = $request;
        $this->inventory = $inventory;
    }

    public function getRequest(): SendItemRequest {
        return $this->request;
    }

    public function getInventory(): Inventory {
        return $this->inventory;
    }

}