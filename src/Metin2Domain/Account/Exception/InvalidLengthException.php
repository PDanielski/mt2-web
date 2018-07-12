<?php


namespace App\Metin2Domain\Account\Exception;



class InvalidLengthException extends \Exception {

    protected $minimumSize;

    protected $maximumSize;

    public function __construct(string $message = "", $minSize, $maxSize) {
        $this->minimumSize = $minSize;
        $this->maximumSize = $maxSize;
        parent::__construct($message);
    }

    public function getMinimumSize(): int {
        return $this->minimumSize;
    }

    public function getMaximumSize(): int {
        return $this->maximumSize;
    }

}