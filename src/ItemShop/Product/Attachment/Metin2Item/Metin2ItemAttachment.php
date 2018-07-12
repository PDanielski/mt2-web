<?php


namespace App\ItemShop\Product\Attachment\Metin2Item;

use App\Item\Courier\Exception\NoEnoughSpaceException;
use App\Item\Courier\ItemCourierInterface;
use App\Item\Request\SendItemRequest;
use App\ItemShop\Order\Order;
use App\ItemShop\Product\Attachment\AttachmentInterface;
use App\ItemShop\Product\Attachment\Exception\AttachmentProcessException;
use App\Metin2Domain\Item\ItemInfo;

class Metin2ItemAttachment implements AttachmentInterface {

    protected $courier;

    protected $itemInfo;

    public function __construct(ItemCourierInterface $courier, ItemInfo $itemInfo) {
        $this->courier = $courier;
        $this->itemInfo = $itemInfo;
    }

    /** @inheritdoc */
    public function process(Order $order) {
        $ownerId = $order->getAccountId();

        $sendItemRequest = new SendItemRequest($ownerId, $this->itemInfo);

        try {
            $this->courier->sendOneItem($sendItemRequest);
        } catch (NoEnoughSpaceException $ex) {
            throw new AttachmentProcessException("You dont have enough space in your inventory");
        }

    }

}