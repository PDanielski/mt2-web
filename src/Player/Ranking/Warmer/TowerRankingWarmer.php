<?php


namespace App\Player\Ranking\Warmer;

class TowerRankingWarmer extends SqlWarmer {

    public function warmup(callable $processIds) {
        $queryBuilder = $this->conn->createQueryBuilder();
        $result = $queryBuilder
            ->select('id')
            ->from($this->table)
            ->where("name not like '%[%'")
            ->andWhere("name not like '%]%'")
            ->orderBy('torre_infinita', 'desc')
            ->execute()
            ->fetchAll();

        $ids = [];
        foreach($result as $row) {
            $ids[] = $row['id'];
        }

        $processIds($ids);
    }
    
}