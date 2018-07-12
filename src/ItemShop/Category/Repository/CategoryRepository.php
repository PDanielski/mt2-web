<?php


namespace App\ItemShop\Category\Repository;


use App\ItemShop\Category\Category;
use App\ItemShop\Product\Product;
use App\ItemShop\Product\Repository\Exception\CategoryNotFoundException;
use Doctrine\DBAL\Connection;

class CategoryRepository implements CategoryRepositoryInterface {

    protected const CATEGORIES_TABLE = "itemshop.categories";

    protected const PRODUCTS_CATEGORIES_TABLE = "itemshop.products_categories";

    protected const SELECTS = [
        'c.category_id',
        'c.name',
        'c.trailer',
        'c.description',
        'c.link_segment'
    ];

    protected $conn;

    public function __construct(Connection $connection) {
        $this->conn = $connection;
    }

    public function getById(int $categoryId): Category {
        $queryBuilder = $this->conn->createQueryBuilder();
        $categoryData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::CATEGORIES_TABLE, 'c')
            ->where('category_id = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->execute()
            ->fetch();

        if(!$categoryData)
            throw new CategoryNotFoundException();

        return $this->createFromSQLData($categoryData);
    }

    public function getByProduct(Product $product): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $categoriesData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::PRODUCTS_CATEGORIES_TABLE, 'pc')
            ->join('pc', self::CATEGORIES_TABLE, 'c', 'c.category_id = pc.category_id')
            ->where('product_id = :productId')
            ->setParameter('productId', $product->getId())
            ->execute()
            ->fetchAll();

        $categories = [];
        foreach($categoriesData as $categoryData) {
            $categories[] = $this->createFromSQLData($categoryData);
        }

        return $categories;
    }

    public function getByLinkSegment(string $linkSegment): Category {
        $queryBuilder = $this->conn->createQueryBuilder();
        $categoryData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::CATEGORIES_TABLE, 'c')
            ->where('link_segment = :linkSegment')
            ->setParameter('linkSegment', $linkSegment)
            ->execute()
            ->fetch();

        if(!$categoryData)
            throw new CategoryNotFoundException();

        return $this->createFromSQLData($categoryData);
    }

    protected function createFromSQLData(array $categoryData): Category {
        return new Category(
            $categoryData['category_id'],
            $categoryData['name'],
            $categoryData['trailer'],
            $categoryData['description'],
            $categoryData['link_segment']
        );
    }

}