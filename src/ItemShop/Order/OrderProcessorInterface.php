<?php


namespace App\ItemShop\Order;


use App\ItemShop\Order\Exception\OrderProcessingException;

interface OrderProcessorInterface {

    /**
     * @param Order $order
     * @return mixed
     * @throws OrderProcessingException
     */
    public function process(Order $order);

}