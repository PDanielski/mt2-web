<?php


namespace App\ItemShop\Order;


use App\ItemShop\Product\Product;
use App\ItemShop\Wallet\Currency\CurrencyInterface;
use App\ItemShop\Wallet\WalletOwner;

class Order {

    protected $product;

    protected $currencyUsed;

    protected $quantity;

    protected $time;

    protected $walletOwner;

    public function __construct(
        Product $product,
        CurrencyInterface $currencyUsed,
        int $quantity,
        \DateTimeImmutable $time,
        WalletOwner $walletOwner
    ) {
        $this->product = $product;
        $this->currencyUsed = $currencyUsed;
        $this->quantity = $quantity;
        $this->time = $time;
        $this->walletOwner = $walletOwner;
    }

    public function getProduct(): Product {
        return $this->product;
    }

    public function getCurrencyUsed(): CurrencyInterface {
        return $this->currencyUsed;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getTime(): \DateTimeImmutable {
        return $this->time;
    }

    public function getWalletOwner(): WalletOwner {
        return $this->walletOwner;
    }

}