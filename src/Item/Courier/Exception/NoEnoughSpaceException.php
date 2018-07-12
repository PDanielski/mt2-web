<?php


namespace App\Item\Courier\Exception;



use App\Item\Request\SendItemRequest;

class NoEnoughSpaceException extends \Exception {

    /** @var SendItemRequest[] */
    protected $requests = array();

    /**
     * NoEnoughSpaceException constructor.
     * @param SendItemRequest[] $requests
     */
    public function __construct(array $requests) {
        $this->requests = $requests;

        $message = "There is no space for the requested items";
        parent::__construct($message);
    }

    /** @return SendItemRequest[] */
    public function getRequests(): array {
        return $this->requests;
    }

}