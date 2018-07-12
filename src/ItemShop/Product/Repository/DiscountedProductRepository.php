<?php


namespace App\ItemShop\Product\Repository;


use App\ItemShop\Discount\DiscountProviderInterface;
use App\ItemShop\Category\Category;
use App\ItemShop\Product\Product;
use App\ItemShop\Product\Tag;

class DiscountedProductRepository implements ProductRepositoryInterface {

    protected $decoratedRepository;

    protected $discountProvider;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        DiscountProviderInterface $discountProvider
    ) {
        $this->decoratedRepository = $productRepository;
        $this->discountProvider = $discountProvider;
    }

    public function getById(int $productId): Product {
        $product = $this->decoratedRepository->getById($productId);
        $discount = $this->discountProvider->get($product);
        if($discount)
            $product->applyDiscount($discount);
        return $product;
    }

    public function getByCategory(Category $category, int $limit = 10, int $offset = 0, array $orderBy = null): array {
        $products = $this->decoratedRepository->getByCategory($category, $limit, $offset, $orderBy);
        $this->processMany($products);
        return $products;
    }

    public function getByTag(Tag $tag, int $limit = 10, int $offset = 0, array $orderBy = null): array {
        $products = $this->decoratedRepository->getByTag($tag, $limit, $offset, $orderBy);
        $this->processMany($products);
        return $products;
    }

    /**
     * @param Product[] &$products
     * @return void
     */
    protected function processMany(array &$products): void {
        if(!$products) return;

        $productsLookupTable = [];
        foreach($products as $index => &$product) {
            $productsLookupTable[$product->getId()] = $index;
        }
        $discounts = $this->discountProvider->getMany($products);
        foreach($discounts as $discount) {
            if(isset($productsLookupTable[$discount->getProduct()->getId()])) {
                $product = &$products[$productsLookupTable[$discount->getProduct()->getId()]];
                $product->applyDiscount($discount);
            } else {
                throw new \RuntimeException("The discount has no product associated. Probably algorithm logic problem");
            }
        }
    }

}