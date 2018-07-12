<?php


namespace App\ItemShop\Order;

use App\ItemShop\Order\Exception\OrderCreationException;
use App\ItemShop\Wallet\WalletOwner;

interface OrderFactoryInterface {

    /**
     * @param int $productId
     * @param string $currencyCode
     * @param int $quantity
     * @param WalletOwner $walletOwner
     * @return Order
     * @throws OrderCreationException
     */
    public function create(
        int $productId,
        string $currencyCode,
        int $quantity,
        WalletOwner $walletOwner
    ): Order;

}