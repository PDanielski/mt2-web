<?php


namespace App\ItemShop\Discount;


use App\ItemShop\Product\Product;

interface DiscountProviderInterface {

    public function get(Product $product): ?Discount;

    /**
     * @param Product[] $products
     * @return Discount[]
     */
    public function getMany(array $products): array;

}