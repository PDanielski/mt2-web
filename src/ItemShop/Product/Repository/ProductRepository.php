<?php


namespace App\ItemShop\Product\Repository;

use App\ItemShop\Media\Hrefable;
use App\ItemShop\Media\Image;
use App\ItemShop\Category\Category;
use App\ItemShop\Product\PriceBuilder;
use App\ItemShop\Product\Product;
use App\ItemShop\Product\Repository\Exception\ProductNotFoundException;
use App\ItemShop\Product\Tag;
use App\ItemShop\Wallet\Currency\CurrencyRepositoryInterface;
use App\ItemShop\Wallet\Currency\Exception\CurrencyNotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class ProductRepository implements ProductRepositoryInterface {

    protected const PRODUCTS_TABLE = 'itemshop.products';

    protected const THUMBNAILS_TABLE = 'itemshop.thumbnails';

    protected const PRODUCTS_PRICES_TABLE = 'itemshop.products_prices';

    protected const PRODUCTS_CATEGORIES_TABLE = 'itemshop.products_categories';

    protected const PRODUCTS_TAGS_TABLE = 'itemshop.products_tags';

    protected const SELECTS = [
        'p.product_id',
        'p.name',
        'p.description',
        'p.trailer',
        'p.insertion_time',
        't.name as thumbnail_name',
        't.thumbnail_id',
        't.href as thumbnail_href',
        "GROUP_CONCAT(CONCAT(pr.currency_code,':', pr.amount) SEPARATOR ' ') as prices"
    ];

    protected $conn;

    protected $currencyRepository;

    public function __construct(Connection $connection, CurrencyRepositoryInterface $currencyRepository) {
        $this->conn = $connection;
        $this->currencyRepository = $currencyRepository;
    }

    public function getById(int $productId): Product {
        $queryBuilder = $this->conn->createQueryBuilder();

        $productData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::PRODUCTS_TABLE, 'p')
            ->leftJoin('p', self::THUMBNAILS_TABLE, 't', 'p.thumbnail_id = t.thumbnail_id')
            ->join('p', self::PRODUCTS_PRICES_TABLE, 'pr', 'pr.product_id = p.product_id')
            ->where('p.product_id = :productId')
            ->groupBy('p.product_id')
            ->setParameter('productId', $productId)
            ->execute()
            ->fetch();

        if(!$productData)
            throw new ProductNotFoundException();

        return $this->createFromSQLResult($productData);
    }

    public function getByCategory(Category $category, int $limit = 10, int $offset = 0, array $orderBy = null): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::PRODUCTS_CATEGORIES_TABLE, 'pc')
            ->join('pc', self::PRODUCTS_TABLE, 'p', 'pc.product_id = p.product_id')
            ->leftJoin('p', self::THUMBNAILS_TABLE, 't', 'p.thumbnail_id = t.thumbnail_id')
            ->join('p', self::PRODUCTS_PRICES_TABLE, 'pr', 'pr.product_id = p.product_id')
            ->where('pc.category_id = :categoryId')
            ->groupBy('p.product_id')
            ->setParameter('categoryId', $category->getId())
            ->setMaxResults($limit)
            ->setFirstResult($offset);
        $this->applyOrder($queryBuilder, $orderBy);

        $productsData = $queryBuilder->execute()->fetchAll();

        $products = [];
        foreach($productsData as $productData) {
            $products[] = $this->createFromSQLResult($productData);
        }

        return $products;
    }

    public function getByTag(Tag $tag, int $limit = 10, int $offset = 0, array $orderBy = null): array {
        $queryBuilder = $this->conn->createQueryBuilder();

        $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::PRODUCTS_TAGS_TABLE, 'pt')
            ->join('pc', self::PRODUCTS_TABLE, 'p', 'pc.product_id = p.product_id')
            ->leftJoin('p', self::THUMBNAILS_TABLE, 't', 'p.thumbnail_id = t.thumbnail_id')
            ->join('p', self::PRODUCTS_PRICES_TABLE, 'pr', 'pr.product_id = p.product_id')
            ->where('pt.tag_id = :tagId')
            ->groupBy('p.product_id')
            ->setParameter('tagId', $tag->getId())
            ->setMaxResults($limit)
            ->setFirstResult($offset);
        $this->applyOrder($queryBuilder, $orderBy);

        $productsData = $queryBuilder->execute()->fetchAll();
        $products = [];
        foreach($productsData as $productData) {
            $products[] = $this->createFromSQLResult($productData);
        }

        return $products;
    }

    protected function createFromSQLResult(array $productData): Product {
        $productId = $productData['product_id'];
        $productName = $productData['name'];
        $productDescription = $productData['description'];
        $productTrailer = $productData['trailer'];
        $productInsertionTime = new \DateTimeImmutable($productData['insertion_time']);
        $thumbnail = $productData['thumbnail_href'] ?
            new Image(
                $productData['thumbnail_id'],
                $productData['thumbnail_name'],
                $productData['thumbnail_href']
            ) :
            new class implements Hrefable {
                public function getHref(): string {
                    return "default-thumbnail";
                }
            };

        $pricesString = $productData['prices'];
        $pricesStrings = explode(' ', $pricesString);
        $currencyCodeToBalance = [];
        foreach($pricesStrings as $currencyAndAmount) {
            $exploded = explode(':', $currencyAndAmount);
            $currencyCodeToBalance[$exploded[0]] = $exploded[1];
        }

        try {
            $priceBuilder = new PriceBuilder();
            foreach($currencyCodeToBalance as $currencyCode => $balance) {
                $currency = $this->currencyRepository->getByCode($currencyCode);
                $priceBuilder->addCurrency($currency, $balance);
            }
        } catch (CurrencyNotFoundException $ex) {
            throw new \RuntimeException($ex->getMessage(), 0, $ex);
        }

        return new Product(
            $productId,
            $productName,
            $productDescription,
            $productTrailer,
            $thumbnail,
            $priceBuilder->getPrice(),
            $productInsertionTime
        );
    }

    protected function applyOrder(QueryBuilder $builder, ?array $order) {
        if(!$order) return;
        $allowedFields = ['name', 'insertion_time'];
        foreach($order as $field => $ascOrDesc) {
            if(strpos($field, 'price.') !== false) {
                $field = explode('.', $field)[1];
            } else if(!in_array($field, $allowedFields))
                throw new \RuntimeException("You cannot order by {$field}");

            if(in_array(strtolower($ascOrDesc), ['asc', 'desc'])) {
                $builder->addOrderBy($field, $ascOrDesc);
            } else {
                $builder->addOrderBy($field, 'ASC');
            }
        }
    }

}