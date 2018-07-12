<?php


namespace App\ItemShop\Product\Attachment;


use App\ItemShop\Order\Order;
use App\ItemShop\Product\Attachment\Exception\AttachmentProcessException;

interface AttachmentInterface {

    /**
     * @param Order $order
     * @return void
     * @throws AttachmentProcessException
     */
    public function process(Order $order);

}