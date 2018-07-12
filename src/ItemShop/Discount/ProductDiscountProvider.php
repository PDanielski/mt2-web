<?php


namespace App\ItemShop\Discount;

use App\ItemShop\Product\PriceBuilder;
use App\ItemShop\Product\Product;
use App\ItemShop\Wallet\Currency\CurrencyRepositoryInterface;
use App\ItemShop\Wallet\Currency\Exception\CurrencyNotFoundException;
use Doctrine\DBAL\Connection;

class ProductDiscountProvider implements DiscountProviderInterface {

    protected const PRODUCTS_DISCOUNTS_TABLE = 'ItemShop.products_discounts';

    protected const SELECTS = [
        'product_id',
        'currency_code',
        'avg(absolute_modifier) as absolute_modifier',
        'sum(relative_modifier) as relative_modifier',
        'sum(percentage_modifier) as percentage_modifier'
    ];

    protected $conn;

    protected $currencyRepository;

    protected $supportedProductIds = [];

    public function __construct(Connection $connection, CurrencyRepositoryInterface $currencyRepository) {
        $this->conn = $connection;
        $this->currencyRepository = $currencyRepository;
    }

    public function get(Product $product): ?Discount {
        $queryBuilder = $this->conn->createQueryBuilder();
        $discountResults = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::PRODUCTS_DISCOUNTS_TABLE)
            ->where('product_id = :productId')
            ->andWhere('start_time <= now()')
            ->andWhere('end_time >= now()')
            ->groupBy(['product_id','currency_code'])
            ->setParameter('productId', $product->getId())
            ->execute()
            ->fetchAll();

        return $this->getDiscountByProductAndRows($product, $discountResults);
    }

    /** @inheritdoc */
    public function getMany(array $products): array {
        $productIds = array_map(function(Product $product) {
            return $product->getId();
        }, $products);

        $queryBuilder = $this->conn->createQueryBuilder();
        $discountResults = $queryBuilder
            ->select(...self::SELECTS )
            ->from(self::PRODUCTS_DISCOUNTS_TABLE)
            ->where('product_id IN(:productIds)')
            ->andWhere('start_time <= now()')
            ->andWhere('end_time >= now()')
            ->groupBy(['product_id','currency_code'])
            ->setParameter('productIds', $productIds, Connection::PARAM_INT_ARRAY)
            ->execute()
            ->fetchAll();

        $indexedRows = [];
        foreach($discountResults as $row) {
            $indexedRows[$row['product_id']][] = $row;
        }

        $discounts = [];
        foreach($products as $product) {
            if(isset($indexedRows[$product->getId()])) {
                $discount = $this->getDiscountByProductAndRows($product, $indexedRows[$product->getId()]);
                if($discount)
                    $discounts[] = $discount;
            }
        }

        return $discounts;
    }

    protected function getDiscountByProductAndRows(Product $product, array $rows): ?Discount {
        try {
            $originalPrice = $product->getPrice();
            $newPriceBuilder = new PriceBuilder($originalPrice);

            $isDiscounted = false;

            foreach($rows as $row) {
                $currency = $this->currencyRepository->getByCode($row['currency_code']);
                if($originalPrice->supportsCurrency($currency)) {
                    $newPrice = $this->calculatePrice(
                        $originalPrice->getPriceUsingXCurrency($currency),
                        $row['absolute_modifier'],
                        $row['relative_modifier'],
                        $row['percentage_modifier']
                    );
                    $newPriceBuilder->addCurrency($currency, $newPrice);
                    $isDiscounted = true;
                }
            }

            if(!$isDiscounted)
                return null;

            $newPrice = $newPriceBuilder->getPrice();

            return new Discount($product, $originalPrice, $newPrice);
        } catch (CurrencyNotFoundException $exception) {
            throw new \RuntimeException($exception->getMessage(), 0, $exception);
        }
    }

    protected function calculatePrice(
        int $originalPrice,
        int $absoluteModifier,
        int $relativeModifier,
        float $percentageModifier
    ): int {
        $price = $absoluteModifier ?: $originalPrice;
        $price += $relativeModifier;

        if($price <= 0)
            throw new \RuntimeException("You cannot discount a product to 0 or below");

        if($percentageModifier)
            $price *= $percentageModifier;

        return $price;
    }

}