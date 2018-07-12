<?php


namespace App\Metin2Domain\Account\Exception;

class NotNumericSocialIdException extends \Exception {

    protected $socialId;

    public function __construct(string $socialId) {
        $this->socialId = $socialId;

        $message = "The socialId must be a numeric string, '{$socialId}' provided";
        parent::__construct($message);
    }

    public function getInvalidSocialId(): string {
        return $this->socialId;
    }

}