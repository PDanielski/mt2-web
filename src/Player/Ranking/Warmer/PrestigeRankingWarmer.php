<?php


namespace App\Player\Ranking\Warmer;

class PrestigeRankingWarmer extends SqlWarmer {

    public function warmup(callable $processIds) {
        $queryBuilder = $this->conn->createQueryBuilder();
        $result = $queryBuilder
            ->select('id')
            ->from($this->table)
            ->orderBy('prestige', 'desc')
            ->addOrderBy('level', 'desc')
            ->addOrderBy('playtime', 'desc')
            ->execute()
            ->fetchAll();

        $ids = [];
        $i = 0;
        foreach($result as $row) {
            $ids[$i++] = $row['id'];
        }
        $processIds($ids);
    }

}