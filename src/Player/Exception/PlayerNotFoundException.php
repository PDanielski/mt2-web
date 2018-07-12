<?php


namespace App\Player\Exception;



class PlayerNotFoundException extends \Exception {

    public function __construct(string $message) {
        parent::__construct($message);
    }

}