<?php


namespace App\Metin2Domain\Account;


use App\Metin2Domain\Account\Exception\InvalidSocialIdLengthException;
use App\Metin2Domain\Account\Exception\NotNumericSocialIdException;

final class SocialId {

    const SIZE = 7;

    protected $socialId;

    /**
     * SocialId constructor.
     * @param string $socialId
     * @throws InvalidSocialIdLengthException
     * @throws NotNumericSocialIdException
     */
    public function __construct(string $socialId) {
        $socialIdLength = strlen($socialId);
        if($socialIdLength !== self::SIZE)
            throw new InvalidSocialIdLengthException($socialId, self::SIZE);

        if(!is_numeric($socialId))
            throw new NotNumericSocialIdException($socialId);

        $this->socialId = $socialId;
    }

    public function getSocialId(): string {
        return $this->socialId;
    }

    public function __toString(): string {
        return $this->getSocialId();
    }

}