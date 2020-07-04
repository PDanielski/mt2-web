<?php


namespace App\PremiumPoints;

use Doctrine\DBAL\Connection;

class PaypalTransactionRepository implements PaypalTransactionRepositoryInterface {

    protected $conn;

    protected $tableName;

    public function __construct(Connection $connection, string $tableName) {
        $this->conn = $connection;
        $this->tableName = $tableName;
    }

    public function insertTransaction(PaypalTransaction $transaction): void {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder->insert($this->tableName)
        ->values([
            'mc_gross' => ':mc_gross',
            'protection_eligibility' => ':protection_eligibility',
            'payer_id' => ':payer_id',
            'address_street' => ':address_street',
            'payment_date' => ':payment_date',
            'payment_status' => ':payment_status',
            'charset' => ':charset',
            'address_zip' => ':address_zip',
            'first_name' => ':first_name',
            'mc_fee' => ':mc_fee',
            'address_country_code' => ':address_country_code',
            'notify_version' => ':notify_version',
            'custom' => ':custom',
            'payer_status' => ':payer_status',
            'business' => ':business',
            'address_country' => ':address_country',
            'address_city' => ':address_city',
            'quantity' => ':quantity',
            'verify_sign' => ':verify_sign',
            'payer_email' => ':payer_email',
            'txn_id' => ':txn_id',
            'payment_type' => ':payment_type',
            'last_name' => ':last_name',
            'receiver_email' => ':receiver_email',
            'payment_fee' => ':payment_fee',
            'receiver_id' => ':receiver_id',
            'txn_type' => ':txn_type',
            'transaction_subject' => ':transaction_subject',
            'ipn_track_id' => ':ipn_track_id',
            'status' => ':status'
        ])
        ->setParameter('mc_gross', $transaction->mc_gross)
        ->setParameter('protection_eligibility', $transaction->protection_eligibility)
        ->setParameter('payer_id', $transaction->payer_id)
        ->setParameter('address_street', $transaction->address_street)
        ->setParameter('payment_date', $transaction->payment_date)
        ->setParameter('payment_status', $transaction->payment_status)
        ->setParameter('charset', $transaction->charset)
        ->setParameter('address_zip', $transaction->address_zip)
        ->setParameter('first_name', $transaction->first_name)
        ->setParameter('mc_fee', $transaction->mc_fee)
        ->setParameter('address_country_code', $transaction->address_country_code)
        ->setParameter('notify_version', $transaction->notify_version)
        ->setParameter('custom', $transaction->custom)
        ->setParameter('payer_status', $transaction->payer_status)
        ->setParameter('business', $transaction->business)
        ->setParameter('address_country', $transaction->address_country)
        ->setParameter('address_city', $transaction->address_city)
        ->setParameter('quantity', $transaction->quantity)
        ->setParameter('verify_sign', $transaction->verify_sign)
        ->setParameter('payer_email', $transaction->payer_email)
        ->setParameter('txn_id', $transaction->txn_id)
        ->setParameter('payment_type', $transaction->payment_type)
        ->setParameter('last_name', $transaction->last_name)
        ->setParameter('receiver_email', $transaction->receiver_email)
        ->setParameter('payment_fee', $transaction->payment_fee)
        ->setParameter('receiver_id', $transaction->receiver_id)
        ->setParameter('txn_type', $transaction->txn_type)
        ->setParameter('transaction_subject', $transaction->transaction_subject)
        ->setParameter('ipn_track_id', $transaction->ipn_track_id)
        ->setParameter('status', $transaction->status)
        ->execute();
    }
}