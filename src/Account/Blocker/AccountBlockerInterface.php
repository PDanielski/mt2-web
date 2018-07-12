<?php


namespace App\Account\Blocker;


use App\Metin2Domain\Account\AccountInterface;

interface AccountBlockerInterface {

    public function block(Block $block, AccountInterface $account);

    public function unblock(Unblock $unblock, AccountInterface $account);

}