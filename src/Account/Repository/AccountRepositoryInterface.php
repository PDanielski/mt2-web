<?php


namespace App\Account\Repository;


use App\Account\Repository\Exception\AccountNotFoundException;
use App\Metin2Domain\Account\AccountInterface;

interface AccountRepositoryInterface {

    /**
     * @param int $id
     * @return AccountInterface
     * @throws AccountNotFoundException
     */
    public function getById(int $id): AccountInterface;

    /**
     * @param string $login
     * @return AccountInterface
     * @throws AccountNotFoundException
     */
    public function getByLogin(string $login): AccountInterface;

}