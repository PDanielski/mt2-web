<?php


namespace App\ItemShop\Discount;


use App\ItemShop\Product\Price;
use App\ItemShop\Product\Product;

class Discount {

    protected $product;

    protected $originalPrice;

    protected $discountedPrice;

    public function __construct(Product $product, Price $originalPrice, Price $discountedPrice) {
        $this->product = $product;
        $this->originalPrice = $originalPrice;
        $this->discountedPrice = $discountedPrice;
    }

    public function getProduct(): Product {
        return $this->product;
    }

    public function getOriginalPrice(): Price {
        return $this->originalPrice;
    }

    public function getDiscountedPrice(): Price {
        return $this->discountedPrice;
    }

}