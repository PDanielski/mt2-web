<?php


namespace App\Player\Ranking\Exception;


class RankingNotRegisteredException extends \Exception{

    public function __construct(string $rankingName) {
        $message = "The ranking named {$rankingName} is not registered";
        parent::__construct($message);
    }

}