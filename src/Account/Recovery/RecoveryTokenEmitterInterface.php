<?php


namespace App\Account\Recovery;


interface RecoveryTokenEmitterInterface {

    public function emit(RecoveryToken $token);

}