<?php


namespace App\ItemShop\Product\Repository;


use App\ItemShop\Category\Category;
use App\ItemShop\Product\Product;
use App\ItemShop\Product\Repository\Exception\ProductNotFoundException;
use App\ItemShop\Product\Tag;

interface ProductRepositoryInterface {

    /**
     * @param int $productId
     * @return Product
     * @throws ProductNotFoundException
     */
    public function getById(int $productId): Product;

    /**
     * @param Category $category
     * @param int $limit
     * @param int $offset
     * @param array[string]string $orderBy
     * @return Product[]
     */
    public function getByCategory(Category $category, int $limit = 20, int $offset = 0, array $orderBy = null): array;

    /**
     * @param Tag $tag
     * @param int $limit
     * @param int $offset
     * @param array[string]string $orderBy
     * @return Product[]
     */
    public function getByTag(Tag $tag, int $limit = 20, int $offset = 0, array $orderBy = null): array;

}