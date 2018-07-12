<?php


namespace App\ItemShop\Product\Attachment\Metin2Item;


use App\Item\Courier\ItemCourierInterface;
use App\Metin2Domain\Item\ItemInfo;

class Metin2ItemAttachmentFactory {

    protected $courier;

    public function __construct(ItemCourierInterface $courier) {
        $this->courier = $courier;
    }

    public function create(ItemInfo $itemInfo) {
        return new Metin2ItemAttachment($this->courier, $itemInfo);
    }

}