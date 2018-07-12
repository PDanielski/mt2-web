<?php


namespace App\ItemShop\Product\Repository;


use App\ItemShop\Product\Product;
use App\ItemShop\Product\Repository\Exception\TagNotFoundException;
use App\ItemShop\Product\Tag;

interface TagRepositoryInterface {

    /**
     * @param int $tagId
     * @return Tag
     * @throws TagNotFoundException
     */
    public function getById(int $tagId): Tag;

    /**
     * @param Product $product
     * @return Tag[]
     */
    public function getByProduct(Product $product): array;

}