<?php


namespace App\Account\Exception;

use App\Account\Request\CreateAccountRequest;

class DuplicateAccountException extends \Exception {

    protected $createRequest;

    public function __construct(CreateAccountRequest $request) {
        $this->createRequest = $request;

        $message = "The account with login '{$request->getLogin()}' already exists";
        parent::__construct($message);
    }

    public function getCreateRequest(): CreateAccountRequest {
        return $this->createRequest;
    }

}