<?php


namespace App\Account\Recovery;


interface RecoveryTokenEncoderInterface {

    public function encode(RecoveryToken $recoveryToken): string;

    public function decode(string $hash): ?RecoveryToken;

}