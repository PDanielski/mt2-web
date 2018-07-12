<?php


namespace App\Metin2Domain\Item\Inventory\Exception;


use App\Metin2Domain\Item\Inventory\Inventory;
use App\Metin2Domain\Item\ItemPrototype;

class FreePositionNotFoundException extends \Exception {

    protected $inventory;

    protected $prototype;

    public function __construct(Inventory $inventory, ItemPrototype $prototype) {
        $this->inventory = $inventory;
        $this->prototype = $prototype;

        $message = "No position found in inventory for item with vnum {$prototype->getItemVnum()}";
        parent::__construct($message);
    }

    public function getInventory(): Inventory {
        return $this->inventory;
    }

    public function getItemPrototype(): ItemPrototype {
        return $this->prototype;
    }

}