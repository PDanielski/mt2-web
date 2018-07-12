<?php


namespace App\Account\Recovery;


use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RecoveryTokenEmitter implements RecoveryTokenEmitterInterface {

    protected $encoder;

    protected $logger;

    protected $mailer;

    protected $repository;

    protected $twig;

    protected $urlGenerator;

    public function __construct(
        RecoveryTokenEncoderInterface $encoder,
        LoggerInterface $logger,
        \Swift_Mailer $mailer,
        AccountRepositoryInterface $repository,
        \Twig_Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->encoder = $encoder;
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->repository = $repository;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    public function emit(RecoveryToken $token) {
        try {
            $acc = $this->repository->getById($token->getAccountId());
            $message = new \Swift_Message("Password recovery request - Metin2Warlords");
            $encodedToken = $this->encoder->encode($token);
            $message
                ->setFrom('webmaster@metin2warlords.net')
                ->setTo($acc->getEmail()->getEmail())
                ->setBody($this->twig->render('mails/recovery.html.twig', [
                    'link' => $this->urlGenerator->generate('lostPasswordChange', [], UrlGeneratorInterface::ABSOLUTE_URL).'?token='.$encodedToken,
                    'name' => $acc->getLogin()
                ]))
                ->setContentType('text/html');
            $this->mailer->send($message);
            $this->logger->info($encodedToken);
        } catch (AccountNotFoundException $ex) {
            throw new \RuntimeException("The account should be existing, but it is not", 0, $ex);
        } catch (\Twig_Error $error) {
            throw new \RuntimeException("Error with templating", 0, $error);
        }

    }

}