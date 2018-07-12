<?php


namespace App\Metin2Domain\Account;

class Account implements AccountInterface {

    protected $id;

    protected $login;

    protected $email;

    protected $password;

    protected $socialId;

    protected $gold;

    protected $warpoints;

    protected $biscuits;

    protected $status;

    protected $blockedUntil;

    public function __construct(
        int $id,
        Login $login,
        Email $email,
        Password $password,
        SocialId $socialId,
        int $gold = 0,
        int $warpoints = 0,
        int $biscuits = 0,
        string $status = AccountStatuses::CONFIRMED,
        \DateTimeImmutable $blockedUntil = null
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->socialId = $socialId;
        $this->gold = $gold;
        $this->warpoints = $warpoints;
        $this->biscuits = $biscuits;
        $this->status = $status;
        $this->blockedUntil = null;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getLogin(): Login {
        return $this->login;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function changeEmail(Email $email): void {
        $this->email = $email;
    }

    public function getPassword(): Password {
        return $this->password;
    }

    public function changePassword(Password $password): void {
        $this->password = $password;
    }

    public function getSocialId(): SocialId {
        return $this->socialId;
    }

    public function getGold(): int {
        return $this->gold;
    }

    public function setGold(int $amount) {
        $this->gold = $amount;
    }

    public function changeGold(int $delta) {
        $this->setGold($this->getGold() + $delta);
    }

    public function getWarpoints(): int {
        return $this->warpoints;
    }

    public function setWarpoints(int $amount) {
        $this->warpoints = $amount;
    }

    public function changeWarpoints(int $delta) {
        $this->setWarpoints($this->getWarpoints() + $delta);
    }

    public function getBiscuits(): int {
        return $this->biscuits;
    }

    public function setBiscuits(int $amount) {
        $this->biscuits = $amount;
    }

    public function changeBiscuits(int $delta) {
        $this->setBiscuits($this->getBiscuits() + $delta);
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status) {
        if(!in_array($status, [AccountStatuses::BANNED, AccountStatuses::CONFIRMED, AccountStatuses::NOT_CONFIRMED]))
            throw new \InvalidArgumentException("{$status} is not a valid status");

        $this->status = $status;
    }

    public function getBlockedUntil(): ?\DateTimeImmutable {
        return $this->blockedUntil;
    }

    public function blockUntil(?\DateTimeImmutable $date) {
        $this->blockedUntil = $date;
    }

    public function blockFor(int $seconds) {
        $date = new \DateTime();
        $date->add(new \DateInterval("PT".$seconds."S"));
        $this->blockUntil(\DateTimeImmutable::createFromMutable($date));
    }

    public function block() {
        if($this->isBlocked())
            $this->unblock();

        $this->setStatus(AccountStatuses::BANNED);
    }

    public function unblock() {
        if($this->isBlocked()) {
            $this->blockUntil(null);
            $this->setStatus(AccountStatuses::CONFIRMED);
        }
    }

    public function isBlocked(): bool {
        return $this->status == AccountStatuses::BANNED || $this->getBlockedUntil();
    }

}