<?php


namespace App\Controller\Api;


use App\Http\JsonErrorResponse;
use App\Player\Ranking\Exception\RankingNotRegisteredException;
use App\Player\Ranking\PlacedPlayer;
use App\Player\Ranking\RankingProviderInterface;
use App\Player\Exception\PlayerNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayerRankingController {

    protected $rankingProvider;

    public function __construct(RankingProviderInterface $rankingProvider) {
        $this->rankingProvider = $rankingProvider;
    }

    /**
     * @Route("/players/ranking/{rankingId}", name="apiGetPlayersRankingAction", methods={"GET"})
     * @param Request $request
     * @param string $rankingId
     * @return JsonResponse | JsonErrorResponse
     */
    public function getAction(Request $request, string $rankingId) {
        $offset = $request->query->has('offset') ? $request->query->get('offset') : 0;
        $limit = $request->query->has('limit') ? $request->query->get('limit') : 10;

        try {
            $ranking = $this->rankingProvider->getRanking($rankingId);
        } catch (RankingNotRegisteredException $ex) {
            return new JsonErrorResponse(404, "The ranking {$rankingId} was not found", 404);
        }

        $start = microtime(true);
        /** @var PlacedPlayer[] $players */
        $players = $ranking->get($offset, $limit);


        $schema = array(
            'executionTime' => microtime(true) - $start,
            'players' => [],
            'startOffset' => $offset,
            'count' => min($limit, count($players))
        );

        foreach($players as $player) {
            $schema['players'][] = $this->buildPlayerPart($player);
        }

        $response =  new JsonResponse($schema);
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        return $response;
    }

    /**
     * @Route("/players/ranking/{rankingId}/name/{playerName}", name="apiGetPlayerRankByNameAction", methods={"GET"})
     * @param string $rankingId
     * @param string $playerName
     * @return JsonResponse | JsonErrorResponse
     */
    public function getPlayerRankByNameAction(string $rankingId,  string $playerName) {
        try {
            $ranking = $this->rankingProvider->getRanking($rankingId);

            $start = microtime(true);
            $player = $ranking->getByName($playerName);
            $schema = array (
                'executionTime' => microtime(true) - $start,
                'player' => $this->buildPlayerPart($player),
                'position' => $player->getPosition()
            );

            $response = new JsonResponse($schema);
            $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
            return $response;
        } catch (RankingNotRegisteredException $ex) {
            return new JsonErrorResponse(404, "The ranking {$rankingId} was not found", 404);
        } catch (PlayerNotFoundException $ex) {
            return new JsonErrorResponse(404, "The player {$playerName} is not registered in the {$rankingId} ranking");
        }
    }

    /**
     * @Route("/players/ranking/{rankingId}/guild/{guildName}", name="apiGetPlayerRankByGuildNameAction", methods={"GET"})
     * @param string $rankingId
     * @param string $guildName
     * @return JsonErrorResponse|JsonResponse
     */
    public function getPlayersRankByGuildNameAction(string $rankingId, string $guildName) {
        try {
            $ranking = $this->rankingProvider->getRanking($rankingId);
        } catch (RankingNotRegisteredException $ex) {
            return new JsonErrorResponse(404, "The ranking {$rankingId} was not found", 404);
        }

        $start = microtime(true);
        /** @var PlacedPlayer[] $players */
        $players = $ranking->getByGuildName($guildName);


        $schema = array(
            'executionTime' => microtime(true) - $start,
            'players' => [],
            'count' => count($players)
        );

        foreach($players as $player) {
            $schema['players'][] = $this->buildPlayerPart($player);
        }

        $response =  new JsonResponse($schema);
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        return $response;
    }

    protected function buildPlayerPart(PlacedPlayer $player) {
        $data = [
            'id' => $player->getId(),
            'position' => $player->getPosition(),
            'accountId' => $player->getAccountId(),
            'name' => $player->getName(),
            'level' => $player->getLevel(),
            'guildName' => $player->getGuildName(),
            'raceName' => $player->getRaceName(),
            'kingdomName' => $player->getKingdomName(),
            'minutesPlayed' => $player->getMinutesPlayed(),
            'mmr' => $player->getMmr(),
            'tower' => $player->getTowerLv(),
            'prestige' => $player->getPrestige()
        ];
        return $data;
    }

}