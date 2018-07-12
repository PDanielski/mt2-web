<?php


namespace App\ItemShop\Wallet\Currency;


use App\ItemShop\Media\Hrefable;

interface CurrencyInterface {

    public function getName(): string;

    public function getCode(): string;

    public function getIcon(): Hrefable;

}