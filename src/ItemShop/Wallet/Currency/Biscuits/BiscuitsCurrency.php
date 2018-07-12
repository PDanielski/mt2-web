<?php


namespace App\ItemShop\Wallet\Currency\Biscuits;


use App\ItemShop\Media\Hrefable;
use App\ItemShop\Wallet\Currency\CurrencyInterface;

class BiscuitsCurrency implements CurrencyInterface {

    public function getCode(): string {
        return "biscuits";
    }

    public function getName(): string {
        return "biscuits";
    }

    public function getIcon(): Hrefable {
        return new class implements Hrefable {
            public function getHref(): string {
                return "https://metin2warlords.net";
            }
        };
    }

}