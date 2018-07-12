<?php


namespace App\Account\Blocker;


interface BlockRecordRepositoryInterface {

    /**
     * @param int $accountId
     * @return BlockRecord[]
     */
    public function getByBlockedAccountId(int $accountId): array;

    /**
     * @param int $accountId
     * @return BlockRecord[]
     */
    public function getByBlockerAccountId(int $accountId): array;

}