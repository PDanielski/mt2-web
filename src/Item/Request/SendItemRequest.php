<?php


namespace App\Item\Request;


use App\Metin2Domain\Item\ItemInfo;

class SendItemRequest {

    protected $receiverId;

    protected $itemInfo;

    public function __construct(int $receiverId, ItemInfo $itemInfo) {
        $this->receiverId = $receiverId;
        $this->itemInfo = $itemInfo;
    }

    public function getReceiverId(): int {
        return $this->receiverId;
    }

    public function getItemInfo(): ItemInfo {
        return $this->itemInfo;
    }

}