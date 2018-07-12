<?php


namespace App\ItemShop\Wallet\Currency\Warpoints;


use App\ItemShop\Media\Hrefable;
use App\ItemShop\Wallet\Currency\CurrencyInterface;

class WarpointsCurrency implements CurrencyInterface {

    public function getCode(): string {
        return "warpoints";
    }

    public function getName(): string {
        return "warpoints";
    }

    public function getIcon(): Hrefable {
        return new class implements Hrefable {
            public function getHref(): string {
                return "https://metin2warlords.net";
            }
        };
    }
}