<?php


namespace App\ItemShop\Product;


use App\ItemShop\Wallet\Currency\CurrencyInterface;

class Price {

    protected $supportedCurrencies;

    protected $currenciesBalances;

    /**
     * Price constructor.
     * @param CurrencyInterface[] $supportedCurrencies
     * @param array[string]int $currenciesBalances
     */
    public function __construct(array $supportedCurrencies, array $currenciesBalances) {
        $this->supportedCurrencies = $supportedCurrencies;
        $this->currenciesBalances = $currenciesBalances;
    }

    public function supportsCurrency(CurrencyInterface $currency): bool {
        return isset($this->currenciesBalances[$currency->getCode()]);
    }

    public function getPriceUsingXCurrency(CurrencyInterface $currency): ?int {
        if($this->currenciesBalances[$currency->getCode()])
            return $this->currenciesBalances[$currency->getCode()];
        return null;
    }

    public function getCurrencies(): array {
        return $this->supportedCurrencies;
    }

    public function getCurrenciesBalances(): array {
        return $this->currenciesBalances;
    }

}