<?php


namespace App\Item\Repository;

use App\Item\Repository\Exception\ItemPrototypeNotFoundException;
use App\Metin2Domain\Item\ItemPrototype;

interface ItemPrototypeRepositoryInterface {

    /**
     * @param int $vnum
     * @return ItemPrototype
     * @throws ItemPrototypeNotFoundException
     */
    public function getByVnum(int $vnum): ItemPrototype;

}