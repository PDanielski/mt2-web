<?php


namespace App\ItemShop\Wallet\Currency\Gold;


use App\ItemShop\Media\Hrefable;
use App\ItemShop\Wallet\Currency\CurrencyInterface;

class GoldCurrency implements CurrencyInterface {

    public function getCode(): string {
        return "gold";
    }

    public function getName(): string {
        return "gold";
    }

    public function getIcon(): Hrefable {
        return new class implements Hrefable {
            public function getHref(): string {
                return "https://metin2warlords.net";
            }
        };
    }
}