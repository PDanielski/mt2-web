<?php


namespace App\PremiumPoints;


interface PaypalTransactionRepositoryInterface {


    public function insertTransaction(PaypalTransaction $transaction): void;

}