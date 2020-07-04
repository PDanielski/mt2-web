<?php

namespace App\Metin2Domain\Account;

interface AccountInterface {

    public function getId(): int;

    public function getLogin(): Login;

    public function getEmail(): Email;

    public function changeEmail(Email $email): void;

    public function getPassword(): Password;

    public function changePassword(Password $password): void;

    public function getSocialId(): SocialId;

    public function getGold(): int;

    public function setGold(int $amount);

    public function changeGold(int $delta);

    public function getWarpoints(): int;

    public function setWarpoints(int $amount);

    public function changeWarpoints(int $delta);

    public function getPremiumpoints(): int;

    public function setPremiumpoints(int $amount);

    public function changePremiumpoints(int $delta);

    public function getStatus(): string;

    public function setStatus(string $status);

    public function getBlockedUntil(): ?\DateTimeImmutable;

    public function blockFor(int $seconds);

    public function blockUntil(?\DateTimeImmutable $date);

    public function block();

    public function unblock();

    public function isBlocked(): bool;

}