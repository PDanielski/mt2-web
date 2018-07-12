<?php


namespace App\ItemShop\Category\Repository;

use App\ItemShop\Category\Category;
use App\ItemShop\Product\Product;
use App\ItemShop\Product\Repository\Exception\CategoryNotFoundException;

interface CategoryRepositoryInterface {

    /**
     * @param int $categoryId
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function getById(int $categoryId): Category;

    /**
     * @param Product $product
     * @return Category[]
     */
    public function getByProduct(Product $product): array;

    /**
     * @param string $linkSegment
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function getByLinkSegment(string $linkSegment): Category;


}