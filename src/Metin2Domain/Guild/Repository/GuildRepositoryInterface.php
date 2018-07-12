<?php


namespace App\Metin2Domain\Guild\Repository;


use App\Metin2Domain\Guild\Guild;

interface GuildRepositoryInterface {

    public function getById(int $id): Guild;

    public function getByMasterId(int $masterId): Guild;

    public function getByName(string $name): Guild;

}