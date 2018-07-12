<?php


namespace App\ItemShop\Wallet\Currency;


use App\ItemShop\Wallet\Currency\Biscuits\BiscuitsCurrency;
use App\ItemShop\Wallet\Currency\Exception\CurrencyNotFoundException;
use App\ItemShop\Wallet\Currency\Gold\GoldCurrency;
use App\ItemShop\Wallet\Currency\Warpoints\WarpointsCurrency;

class CurrencyRepository implements CurrencyRepositoryInterface {

    /** @var CurrencyInterface[] */
    protected $currencies = [];

    protected $codeIndex = [];

    public function __construct() {
        $this->currencies = [
            new GoldCurrency(),
            new WarpointsCurrency(),
            new BiscuitsCurrency()
        ];

        foreach($this->currencies as $index => $currency) {
            $this->codeIndex[$currency->getCode()] = $index;
        }
    }

    public function getAll(): array {
        return $this->currencies;
    }

    public function getByCode(string $currencyCode): CurrencyInterface {
        if(isset($this->codeIndex[$currencyCode])) {
            $index = $this->codeIndex[$currencyCode];
            if(isset($this->currencies[$index]))
                return $this->currencies[$index];
            throw new \RuntimeException("The index {$index} does not exist. Probably algorithm error");
        }
        throw new CurrencyNotFoundException("The currency with code {$currencyCode} was not found");
    }

}