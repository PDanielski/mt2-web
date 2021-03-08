<?php


namespace App\Controller\Api;

use App\Account\Event\AccountCreatedEvent;
use App\Account\Event\EmailChangedEvent;
use App\Account\Event\PasswordChangedEvent;
use App\Http\JsonErrorResponse;
use App\Account\Registration\AccountRegistrationInterface;
use App\Account\Request\CreateAccountRequest;
use App\Account\Exception\DuplicateAccountException;
use App\Metin2Domain\Account\Exception\EmailNotValidException;
use App\Metin2Domain\Account\Exception\InvalidLoginLengthException;
use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use App\Metin2Domain\Account\Exception\InvalidSocialIdLengthException;
use App\Metin2Domain\Account\Exception\NotNumericSocialIdException;
use App\Account\Repository\AccountRepositoryInterface;
use App\Metin2Domain\Account\Email;
use App\Metin2Domain\Account\Login;
use App\Metin2Domain\Account\Password;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\Metin2Domain\Account\SocialId;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController {

    protected $urlGenerator;

    protected $dispatcher;

    public function __construct(UrlGeneratorInterface $urlGenerator, EventDispatcherInterface $dispatcher) {
        $this->urlGenerator = $urlGenerator;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/accounts/{id}", name="apiGetAccountAction",methods={"GET"})
     * @param int $id
     * @param AccountRepositoryInterface $accountRepository
     * @return JsonResponse
     */
    public function getAction(int $id, AccountRepositoryInterface $accountRepository){
        try {
            $account = $accountRepository->getById($id);
            $schema = function (string $login, string $email) {
                return array(
                    'account' => [
                        'login' => $login,
                        'email' => $email
                    ]
                );
            };

            return new JsonResponse($schema($account->getLogin(), $account->getEmail()));

        } catch (AccountNotFoundException $accountNotFoundException) {
            return new JsonErrorResponse(404, "Account not found");
        }
    }

    /**
     * @Route("/accounts", name="apiCreateAccountAction", methods={"POST"})
     * @param Request $request
     * @param AccountRegistrationInterface $accountRegistration
     * @return JsonErrorResponse|JsonResponse
     */
    public function createAction(Request $request, AccountRegistrationInterface $accountRegistration){
        $schema = array(
            'account' => [
                'login' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'socialId' => ''
            ],
            'g-recaptcha-response' => ''
        );

        $json = $request->getContent();
        $requestSchema = json_decode($json, true);

        $merge = function ($schema, $requestSchema) {
            $helper = function(&$schema, $requestSchema) use(&$helper) {
                foreach($schema as $field => &$value) {
                    if(!is_array($value)){
                        if(isset($requestSchema[$field])){
                            if(is_array($requestSchema[$field]))
                                $requestSchema[$field] = '';
                            $schema[$field] = $requestSchema[$field];
                        }
                    }

                    if(isset($requestSchema[$field]) && is_array($requestSchema[$field]))
                        $helper($value, $requestSchema[$field]);
                }
            };
            $helper($schema, $requestSchema);
            return $schema;
        };

        $accountData = $merge($schema, $requestSchema);

        $errorCount = 0;
        $errorSchema = [
            'fieldErrors' => []
        ];
        $addFieldError = function(string $field, string $message) use(&$errorSchema, &$errorCount) {
            $errorSchema['fieldErrors'][] = [
                'field' => $field,
                'message' => $message
            ];
            $errorCount++;
        };

        try {
            $login = new Login($accountData['account']['login']);
        } catch (InvalidLoginLengthException $ex) {
            $addFieldError('login', sprintf(
                "The login should have at least %d and at most %d characters",
                Login::MIN_LENGTH,
                Login::MAX_LENGTH
            ));
        }

        try {
            $email = new Email($accountData['account']['email']);
        } catch (EmailNotValidException $ex) {
            $addFieldError('email', 'The email must be valid');
        }

        try {
            $password =  new Password($accountData['account']['password']);
        } catch (InvalidPasswordLengthException $ex) {
            $addFieldError('password', sprintf(
                "The password must have at least %d and at most %d characters",
                Password::MIN_LENGTH,
                Password::MAX_LENGTH
            ));
        }

        try {
            $socialId = new SocialId($accountData['account']['socialId']);
        } catch (InvalidSocialIdLengthException $ex) {
            $addFieldError('socialId', 'The socialId must have 7 numbers');
        } catch (NotNumericSocialIdException $ex) {
            $addFieldError('socialId', 'The socialId must have 7 numbers');
        }

        $plainPassword = $accountData['account']['password'];
        $confirmationPassword = $accountData['account']['confirmPassword'];
        if($plainPassword !== $confirmationPassword || !$confirmationPassword) {
            $addFieldError('confirmPassword', 'This field must match the Password field');
        }

        $data = array(
            'secret' => '6LcPQK8ZAAAAAH1Pa69D3tWHNiIThpZCFIYujOYb',
            'response' => $accountData['g-recaptcha-response']
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($verify));
        if(!$response->success)
            $addFieldError('g-recaptcha-response', 'Invalid recaptcha');

        if($errorCount > 0) {
            return new JsonResponse($errorSchema, 400);
        }

        try {
            $createRequest = new CreateAccountRequest($login, $email, $password, $socialId);

            $account = $accountRegistration->register($createRequest);
            $this->dispatcher->dispatch(AccountCreatedEvent::NAME, new AccountCreatedEvent($account));
            $response = new JsonResponse();
            $response->setStatusCode(201);
            $response->headers->set(
                'Location',
                $this->urlGenerator->generate('apiGetAccountAction', ['id'=>$account->getId()])
            );

            return $response;
        } catch (DuplicateAccountException $duplicateAccountException) {
            $addFieldError('login', 'There is already an account with this login');
            return new JsonResponse($errorSchema, 400);
        }
    }

    /**
     * @Route("/accounts/{accountId}/password", name="apiChangeAccountPasswordAction", methods={"PUT"})
     * @param Request $request
     * @param int $accountId
     * @param AccountRepositoryInterface $repository
     * @return JsonErrorResponse|JsonResponse
     */
    public function changePasswordAction(Request $request, int $accountId, AccountRepositoryInterface $repository){
        $decodedContent = json_decode($request->getContent(), true);

        if(!isset($decodedContent['password']))
            return new JsonErrorResponse(400, "There must be a password field containing the new password");

        $newPassword = $decodedContent['password'];

        try {
            $isEncoded = isset($decodedContent['is-encoded']) && $decodedContent['is-encoded'];
            $password = new Password($newPassword, $isEncoded);
            $account = $repository->getById($accountId);
            $account->changePassword($password);
            $this->dispatcher->dispatch(PasswordChangedEvent::NAME, new PasswordChangedEvent($accountId, $password, ['where' => 'api']));
            return new JsonResponse();

        } catch (InvalidPasswordLengthException $invalidPasswordLengthException) {
            return new JsonErrorResponse(400, $invalidPasswordLengthException->getMessage());
        } catch (AccountNotFoundException $accountNotFoundException) {
            return new JsonErrorResponse(
                404,
                "The account with id {$accountId} does not exist",
                400
            );
        }
    }

    /**
     * @Route("/accounts/{accountId}/email", name="apiChangeAccountEmailAction", methods={"PUT"})
     * @param Request $request
     * @param int $accountId
     * @param AccountRepositoryInterface $repository
     * @return JsonErrorResponse|JsonResponse
     */
    public function changeEmailAction(Request $request, int $accountId, AccountRepositoryInterface $repository) {
        $decodedContent = json_decode($request->getContent(), true);

        if(!isset($decodedContent['email']))
            return new JsonErrorResponse(400, "There must be an email field containing the new email");

        $newEmail = $decodedContent['email'];

        try {
            $email = new Email($newEmail);
            $account = $repository->getById($accountId);
            $account->changeEmail($email);
            $this->dispatcher->dispatch(EmailChangedEvent::NAME, new EmailChangedEvent($accountId, $email, ['where' => 'api']));
            return new JsonResponse();
        } catch (EmailNotValidException $emailNotValidException) {
            return new JsonErrorResponse(400, $emailNotValidException->getMessage());
        } catch (AccountNotFoundException $accountNotFoundException) {
            return new JsonErrorResponse(
                404,
                "The account with id {$accountId} does not exist",
                400
            );
        }
    }

}
