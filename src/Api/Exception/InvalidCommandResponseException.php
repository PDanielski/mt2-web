<?php


namespace App\Api\Exception;


use App\Api\Command\CommandMetaDataInterface;
use Throwable;

class InvalidCommandResponseException extends \Exception {
    protected $command;
    protected $invalidResponse;

    public function __construct($invalidResponse, CommandMetaDataInterface $command, Throwable $previous = null) {
        $this->command = $command;
        $this->invalidResponse = $invalidResponse;
        $message = "The command ".$command->getCommandName().' received an invalid response: '.$this->invalidResponse.
         ' and returned the error: '.$command->getError();
        parent::__construct($message, $command->getErrorCode(), $previous);
    }

    public function getError(){
        return $this->command->getError();
    }
}