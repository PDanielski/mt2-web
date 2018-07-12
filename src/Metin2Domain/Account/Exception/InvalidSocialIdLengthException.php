<?php


namespace App\Metin2Domain\Account\Exception;


class InvalidSocialIdLengthException extends \Exception {

    protected $socialId;

    protected $expectedSize;

    public function __construct(string $socialId, int $expectedSize) {
        $this->socialId = $socialId;
        $this->expectedSize = $expectedSize;

        $message = "The Social ID should be exactly {$expectedSize}";
        parent::__construct($message);
    }

    public function getInvalidSocialId(): string {
        return $this->socialId;
    }

    public function getExpectedSize(): int {
        return $this->expectedSize;
    }

}