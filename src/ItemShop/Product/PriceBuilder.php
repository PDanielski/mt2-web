<?php


namespace App\ItemShop\Product;


use App\ItemShop\Wallet\Currency\CurrencyInterface;

class PriceBuilder {

    protected $currencies = [];

    protected $balances = [];

    public function __construct(Price $initialPrice = null) {
        if($initialPrice) {
            $this->merge($initialPrice);
        }
    }

    public function merge(Price $price) {
        $currencies = $price->getCurrencies();
        foreach($currencies as $currency) {
            $this->addCurrency($currency, $price->getPriceUsingXCurrency($currency));
        }
        return $this;
    }

    public function addCurrency(CurrencyInterface $currency, int $balance): self {
        $this->currencies[] = $currency;
        $this->balances[$currency->getCode()] = $balance;
        return $this;
    }

    public function getPrice(): Price {
        if(count($this->currencies) <= 0 || count($this->balances) <= 0)
            throw new \RuntimeException("You cannot build a price without adding at least 1 currency");

        return new Price($this->currencies, $this->balances);
    }

}