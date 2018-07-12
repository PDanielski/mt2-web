<?php


namespace App\Controller\Api;

use App\Account\Event\PasswordChangedEvent;
use App\Account\Recovery\RecoveryToken;
use App\Account\Recovery\RecoveryTokenEmitterInterface;
use App\Account\Recovery\RecoveryTokenEncoderInterface;
use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use App\Metin2Domain\Account\Password;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PasswordRecoveryController {

    /**
     * @Route("/password-recovery/emit-token", name="apiEmitLostPasswordTokenAction", methods={"POST"})
     * @param Request $request
     * @param RecoveryTokenEmitterInterface $emitter
     * @param AccountRepositoryInterface $repository
     * @return JsonResponse
     */
    public function generateAndSendTokenAction(
        Request $request,
        RecoveryTokenEmitterInterface $emitter,
        AccountRepositoryInterface $repository
    ) {
        $json = json_decode($request->getContent(), true);

        if(!isset($json['login']) || !is_string($json['login']) || !strlen($json['login']))
            return new JsonResponse('Wrong request format', 400);

        $login = $json['login'];

        try {
            $account = $repository->getByLogin($login);
        } catch (AccountNotFoundException $exception) {
            return new JsonResponse('Account not found', 400);
        }

        $timestamp = time();
        $token = new RecoveryToken($account->getId(), $timestamp, $timestamp + 900);
        $emitter->emit($token);

        $email = $account->getEmail()->getEmail();
        $splitted = explode('@', $email);
        $user = $splitted[0];
        $domain = $splitted[1];
        $asterisksCount = (int)(strlen($user) * (2/3));
        for($i = 0, $length = strlen($user); $i < $asterisksCount && $i < $length; $i++) {
            $user[$length - 1 - $i] = '*';
        }

        return new JsonResponse(["email" => $user.'@'.$domain]);
    }

    /**
     * @Route("/password-recovery/change-password", name="apiChangeLostPasswordAction", methods={"POST"})
     * @param Request $request
     * @param AccountRepositoryInterface $repository
     * @param RecoveryTokenEncoderInterface $encoder
     * @param EventDispatcherInterface $dispatcher
     * @return JsonResponse
     */
    public function changePasswordAction(
        Request $request,
        AccountRepositoryInterface $repository,
        RecoveryTokenEncoderInterface $encoder,
        EventDispatcherInterface $dispatcher
    )
    {
        $json = json_decode($request->getContent(), true);

        if(!isset($json['token']))
            return new JsonResponse("The token is not set", 400);

        $recoveryToken = $encoder->decode($json['token']);
        if(!($recoveryToken && $recoveryToken->isValid())) {
            return new JsonResponse("The token is not valid", 400);
        }

        if(!(isset($json['password']) && isset($json['confirmPassword']))) {
            return new JsonResponse("Wrong format", 400);
        }

        $password = $json['password'];
        $confirmPassword = $json['confirmPassword'];

        if($password !== $confirmPassword) {
            return new JsonResponse("The passwords doesn't match", 400);
        }

        try {
            $password = new Password($password);
            $repository
                ->getById($recoveryToken->getAccountId())
                ->changePassword($password);
            $dispatcher->dispatch(PasswordChangedEvent::NAME,
                new PasswordChangedEvent($recoveryToken->getAccountId(),
                    $password,
                    ['where' => 'recovery'])
            );
            return new JsonResponse();
        } catch (InvalidPasswordLengthException $ex) {
            return new JsonResponse("The password is too short or too long", 400);
        } catch (AccountNotFoundException $ex) {
            return new JsonResponse("Internal error", 400);
        }
    }

}