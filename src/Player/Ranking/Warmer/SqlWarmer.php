<?php


namespace App\Player\Ranking\Warmer;

use Doctrine\DBAL\Connection;

abstract class SqlWarmer implements RankingWarmerInterface {

    protected $conn;

    protected $table;

    public function __construct(Connection $connection, string $table) {
        $this->conn = $connection;
        $this->table = $table;
    }

}