<?php


namespace App\Player\Ranking;


use App\Player\Ranking\Exception\RankingNotRegisteredException;

class RankingProvider implements RankingProviderInterface {

    protected $registry = array();

    public function registerRanking(PlayerRankingInterface $ranking) {
        $this->registry[$ranking->getId()] = $ranking;
    }

    /** @inheritdoc */
    public function getRanking(string $id): PlayerRankingInterface {
        if(isset($this->registry[$id]))
            return $this->registry[$id];

        throw new RankingNotRegisteredException($id);
    }

}