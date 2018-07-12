<?php


namespace App\Metin2Domain\Item\Inventory;


class InventoryFactory {

    public static function createMallInventory(): Inventory {
        return new Inventory('MALL', 1, 9, 5);
    }

    public static function createLiveInventory(): Inventory {
        return new Inventory('INVENTORY', 4, 9, 5);
    }

}