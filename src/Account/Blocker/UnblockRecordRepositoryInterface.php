<?php


namespace App\Account\Blocker;

interface UnblockRecordRepositoryInterface {

    /**
     * @param int $accountId
     * @return UnblockRecord[]
     */
    public function getByBlockedAccountId(int $accountId): array;

    /**
     * @param int $accountId
     * @return UnblockRecord[]
     */
    public function getByUnblockerAccountId(int $accountId): array;

}