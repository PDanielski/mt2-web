<?php


namespace App\Player\Ranking\Warmer;

class MmrRankingWarmer extends SqlWarmer {

    public function warmup(callable $processIds) {
        $queryBuilder = $this->conn->createQueryBuilder();
        $result = $queryBuilder
            ->select('id')
            ->from($this->table)
            ->where("name not like '%[%'")
            ->andWhere("name not like '%]%'")
            ->orderBy('mmr', 'desc')
            ->addOrderBy('playtime', 'desc')
            ->execute()
            ->fetchAll();

        $ids = [];
        foreach($result as $row) {
            $ids[] = $row['id'];
        }

        $processIds($ids);
    }
    
}