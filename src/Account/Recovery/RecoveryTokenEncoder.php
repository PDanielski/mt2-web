<?php


namespace App\Account\Recovery;


use Firebase\JWT\JWT;

class RecoveryTokenEncoder implements RecoveryTokenEncoderInterface {

    protected const TOKEN_VALIDITY_TIME = 600;

    protected const JWT_ALGORITHMS = ['HS256'];

    protected $appSecret;

    public function __construct(string $appSecret) {
        $this->appSecret = $appSecret;
    }

    public function encode(RecoveryToken $recoveryToken): string {
        $payload = [
            'iat' => $recoveryToken->whenWasEmitted(),
            'exp' => $recoveryToken->whenExpires(),
            'accountId' => $recoveryToken->getAccountId()
        ];
        return JWT::encode($payload, $this->appSecret);
    }

    public function decode(string $hash): ?RecoveryToken {
        try {
            $payload = JWT::decode($hash, $this->appSecret, self::JWT_ALGORITHMS);
            return new RecoveryToken($payload->accountId, $payload->iat, $payload->exp);
        } catch (\Exception $ex) {
            return null;
        }
    }

}