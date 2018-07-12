<?php


namespace App\Controller\Api;

use App\Account\Event\EmailChangedEvent;
use App\Account\Event\PasswordChangedEvent;
use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\Form\FormErrors;
use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Exception\EmailNotValidException;
use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use App\Metin2Domain\Account\Password;
use App\Security\Metin2User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController {

    /**
     * @Route("/settings/change-password", name="apiChangePasswordAction", methods={"POST"})
     * @param Request $request
     * @param AccountRepositoryInterface $repository
     * @param EventDispatcherInterface $dispatcher
     * @param UserInterface|null $user
     * @return JsonResponse
     */
    public function changePasswordAction(
        Request $request,
        AccountRepositoryInterface $repository,
        EventDispatcherInterface $dispatcher,
        UserInterface $user = null
    ) {
        if(!$user)
            return new JsonResponse('', 401);

        if(!$user instanceof Metin2User) {
            throw new \RuntimeException("Expected an instance of Metin2User");
        }

        $decodedJson = json_decode($request->getContent(), true);
        $schema = [
            'oldPassword' => '',
            'newPassword' => '',
            'confirmNewPassword' => ''
        ];

        $formErrors = new FormErrors();
        if(!isset($decodedJson['oldPassword'])){
            $formErrors->addFieldError('oldPassword', 'You must insert the old password');
        } else {
            try {
                $encoded = (new Password($decodedJson['oldPassword']))->getEncryptedPassword();
                if($encoded !== $user->getPassword()) {
                    $formErrors->addFieldError('oldPassword', 'Invalid old password');
                }
            } catch (InvalidPasswordLengthException $ex) {
                $formErrors->addFieldError('oldPassword', 'Invalid old password');
            }
        }

        $password = '';
        if(!isset($decodedJson['newPassword'])){
            $formErrors->addFieldError('newPassword', 'You must insert the new password');
        } else {
            try {
                $password = new Password($decodedJson['newPassword']);
            } catch(InvalidPasswordLengthException $exception) {
                $formErrors->addFieldError('newPassword', $exception->getMessage());
            }
        }

        if(!isset($decodedJson['confirmNewPassword'])){
            $formErrors->addFieldError('confirmNewPassword', 'You must confirm your password');
        } else {
            if(!isset($decodedJson['newPassword']) || $decodedJson['confirmNewPassword'] !== $decodedJson['newPassword']){
                $formErrors->addFieldError('confirmNewPassword', "The passwords don't match");
            }
        }

        if($formErrors->hasErrors()){
            return new JsonResponse($formErrors->toJson(),400, [], true);
        }

        try {
            $repository
                ->getById($user->getAccountId())
                ->changePassword($password);
            $dispatcher->dispatch(PasswordChangedEvent::NAME, new PasswordChangedEvent($user->getAccountId(),$password, ['where' => 'settings']));
            return new JsonResponse();
        } catch (AccountNotFoundException $exception) {
            throw new \RuntimeException("The account was not found even if it should exists");
        }
    }

    /**
     * @Route("/settings/change-email", name="apiChangeEmailAction", methods={"POST"})
     * @param Request $request
     * @param AccountRepositoryInterface $repository
     * @param EventDispatcherInterface $dispatcher
     * @param UserInterface|null $user
     * @return JsonResponse
     */
    public function changeEmailAction(
        Request $request,
        AccountRepositoryInterface $repository,
        EventDispatcherInterface $dispatcher,
        UserInterface $user = null
    ) {
        if(!$user)
            return new JsonResponse('', 401);

        if(!$user instanceof Metin2User) {
            throw new \RuntimeException("Expected an instance of Metin2User");
        }

        $decodedJson = json_decode($request->getContent(), true);
        $schema = [
            'oldPassword' => '',
            'newEmail' => '',
            'confirmNewEmail' => ''
        ];

        $formErrors = new FormErrors();
        if(!isset($decodedJson['oldPassword'])){
            $formErrors->addFieldError('oldPassword', 'You must insert the old password');
        } else {
            try {
                $encoded = (new Password($decodedJson['oldPassword']))->getEncryptedPassword();
                if($encoded !== $user->getPassword()) {
                    $formErrors->addFieldError('oldPassword', 'Invalid old password');
                }
            } catch (InvalidPasswordLengthException $ex) {
                $formErrors->addFieldError('oldPassword', 'Invalid old password');
            }
        }

        $email = '';
        if(!isset($decodedJson['newEmail'])){
            $formErrors->addFieldError('newEmail', 'You must insert the new email');
        } else {
            try {
                $email = new Email($decodedJson['newEmail']);
            } catch(EmailNotValidException $exception) {
                $formErrors->addFieldError('newEmail', 'Email not valid');
            }
        }

        if(!isset($decodedJson['confirmNewEmail'])){
            $formErrors->addFieldError('confirmNewEmail', 'You must confirm your email');
        } else {
            if(!isset($decodedJson['newEmail']) || $decodedJson['confirmNewEmail'] !== $decodedJson['newEmail']){
                $formErrors->addFieldError('confirmNewEmail', "The emails don't match");
            }
        }

        if($formErrors->hasErrors()){
            return new JsonResponse($formErrors->toJson(),400, [], true);
        }

        try {
            $repository
                ->getById($user->getAccountId())
                ->changeEmail($email);
            $dispatcher->dispatch(EmailChangedEvent::NAME, new EmailChangedEvent($user->getAccountId(), $email, ['where' => 'settings']));
            return new JsonResponse();
        } catch (AccountNotFoundException $exception) {
            throw new \RuntimeException("The account was not found even if it should exists");
        }
    }

}