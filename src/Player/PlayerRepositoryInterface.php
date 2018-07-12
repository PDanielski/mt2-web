<?php


namespace App\Player;


use App\Metin2Domain\Player\Player;
use App\Player\Exception\PlayerNotFoundException;

interface PlayerRepositoryInterface {

    /**
     * @param int $id
     * @return Player
     * @throws PlayerNotFoundException
     */
    public function getById(int $id): Player;

    /**
     * @param string $name
     * @return Player
     * @throws PlayerNotFoundException
     */
    public function getByName(string $name): Player;

    /**
     * @param int $accountId
     * @return Player[]
     */
    public function getByAccountId(int $accountId): array;

    /**
     * @param string $ip
     * @return Player[]
     */
    public function getByIp(string $ip): array;

}