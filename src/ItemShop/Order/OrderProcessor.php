<?php


namespace App\ItemShop\Order;


use App\ItemShop\Order\Exception\OrderProcessingException;
use App\ItemShop\Product\Attachment\AttachmentsProviderInterface;
use App\ItemShop\Product\Attachment\Exception\AttachmentProcessException;
use App\ItemShop\Wallet\Currency\Exception\CurrencyWalletNotFoundException;
use App\ItemShop\Wallet\Currency\Exception\NotEnoughBalanceException;
use App\ItemShop\Wallet\Exception\WalletOwnerNotFound;
use App\ItemShop\Wallet\WalletProviderFactoryInterface;

class OrderProcessor implements OrderProcessorInterface {

    protected $walletProviderFactory;

    protected $attachmentsProvider;

    public function __construct(
        WalletProviderFactoryInterface $walletProviderFactory,
        AttachmentsProviderInterface $attachmentsProvider
    ) {
        $this->walletProviderFactory = $walletProviderFactory;
        $this->attachmentsProvider = $attachmentsProvider;
    }

    public function process(Order $order) {
        try {
            $product = $order->getProduct();
            if(!$product->getPrice()->supportsCurrency($order->getCurrencyUsed()))
                throw new OrderProcessingException(
                    "The product does not support the currency {$order->getCurrencyUsed()->getName()}"
                );

            $wallet = $this->walletProviderFactory->create($order->getWalletOwner())->get();
            if(!$wallet->supportsCurrency($order->getCurrencyUsed()))
                throw new OrderProcessingException(
                    "The currency {$order->getCurrencyUsed()->getName()} is not supported by the wallet"
                );

            $currencyWallet = $wallet->getCurrencyWallet($order->getCurrencyUsed());
            $balance = $currencyWallet->getBalance();
            $price = $product->getPrice()->getPriceUsingXCurrency($order->getCurrencyUsed());
            if($balance >= $price) {
                $attachments = $this->attachmentsProvider->getByProduct($product);
                foreach($attachments as $attachment) {
                    $attachment->process($order);
                }
                $currencyWallet->withdraw($price);
            } else {
                throw new NotEnoughBalanceException();
            }
        } catch (WalletOwnerNotFound $ex) {
            throw new OrderProcessingException(
                "The owner with id {$order->getWalletOwner()->getId()} has no wallet associated"
            );
        } catch (CurrencyWalletNotFoundException $ex) {
            throw new \RuntimeException(
                "The wallet does not contain a currency wallet for {$order->getCurrencyUsed()->getName()}"
            );
        } catch (NotEnoughBalanceException $ex) {
            throw new OrderProcessingException(
                "The account with id {$order->getWalletOwner()->getId()} has not enough {$order->getCurrencyUsed()->getName()}"
            );
        } catch (AttachmentProcessException $ex) {
            throw new OrderProcessingException(
                "A problem occurred while processing attachments: {$ex->getMessage()}"
            );
        }
    }

}