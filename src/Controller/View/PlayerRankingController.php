<?php


namespace App\Controller\View;


use App\Player\Ranking\Exception\RankingNotRegisteredException;
use App\Player\Ranking\RankingProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PlayerRankingController extends Controller {

    /**
     * @Route("/players/ranking/{rankingId}/{page}", name="getPlayerRankingAction")
     * @param int $page
     * @param string $rankingName
     * @param RankingProviderInterface $rankingProvider
     * @return Response
     */
    public function getPlayerRankingAction(int $page = 1, string $rankingId, RankingProviderInterface $rankingProvider){
        $page = $page > 1 ? $page : 1;
        try {
            $ranking = $rankingProvider->getRanking($rankingId);
        } catch(RankingNotRegisteredException $registeredException) {
            throw new NotFoundHttpException();
        }
        $playerCount = $ranking->getNumOfRankedPlayers();
        $perPagePlayers = 20;
        $maxPage = $playerCount/$perPagePlayers + 1;
        return $this->render('pages/player-ranking.html.twig', [
            'currentPage' => $page,
            'pageSize' => $perPagePlayers,
            'maxPage' => $maxPage,
            'rankingId' => $rankingId,
            'rankingMeta' => $ranking->getMetaInfo()
        ]);
    }

}