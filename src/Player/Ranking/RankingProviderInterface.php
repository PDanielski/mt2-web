<?php


namespace App\Player\Ranking;


use App\Player\Ranking\Exception\RankingNotRegisteredException;

interface RankingProviderInterface {

    public function registerRanking(PlayerRankingInterface $ranking);

    /**
     * @param string $id
     * @return PlayerRankingInterface
     * @throws RankingNotRegisteredException
     */
    public function getRanking(string $id): PlayerRankingInterface;

}