<?php


namespace App\ItemShop\Order;


use App\ItemShop\Order\Exception\OrderCreationException;
use App\ItemShop\Product\Repository\Exception\ProductNotFoundException;
use App\ItemShop\Product\Repository\ProductRepositoryInterface;
use App\ItemShop\Wallet\Currency\CurrencyRepositoryInterface;
use App\ItemShop\Wallet\Currency\Exception\CurrencyNotFoundException;
use App\ItemShop\Wallet\WalletOwner;

class OrderFactory implements OrderFactoryInterface {

    protected $productRepository;

    protected $currencyRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CurrencyRepositoryInterface $currencyRepository
    ) {
        $this->productRepository = $productRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function create(
        int $productId,
        string $currencyCode,
        int $quantity,
        WalletOwner $walletOwner
    ): Order {
        try {
            $product = $this->productRepository->getById($productId);
            $currency = $this->currencyRepository->getByCode($currencyCode);
            return new Order(
                $product,
                $currency,
                $quantity,
                new \DateTimeImmutable(),
                $walletOwner
            );
        } catch (ProductNotFoundException $exception) {
            throw new OrderCreationException("The product with id {$productId} does not exist.", 0, $exception);
        } catch (CurrencyNotFoundException $exception) {
            throw new OrderCreationException("The currency with code {$currencyCode} does not exists", 0, $exception);
        }
    }

}