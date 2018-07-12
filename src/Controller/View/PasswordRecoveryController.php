<?php


namespace App\Controller\View;


use App\Account\PasswordChangerInterface;
use App\Account\Recovery\RecoveryToken;
use App\Account\Recovery\RecoveryTokenEmitterInterface;
use App\Account\Recovery\RecoveryTokenEncoderInterface;
use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\Account\Request\ChangePasswordRequest;
use App\Metin2Domain\Account\Exception\InvalidPasswordLengthException;
use App\Metin2Domain\Account\Password;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordRecoveryController extends Controller {

    /**
     * @Route("/lost-password", name="lostPassword")
     */
    public function indexAction() {
        return $this->render('pages/lost-password.html.twig');
    }

    /**
     * @Route("lost-password/success", name="lostPasswordSuccess")
     * @param Request $request
     * @return Response
     */
    public function successAction(Request $request) {
        if($request->query->has('email')){
            $email = $request->query->get('email');
        } else {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('pages/lost-password-success.html.twig', ['email' => $email]);
    }

    /**
     * @Route("/lost-password/change", name="lostPasswordChange", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request) {
        if(!$request->query->has('token'))
            return $this->redirectToRoute('homepage');

        return $this->render('pages/lost-password-change.html.twig');
    }

    /** @Route("lost-password/change/success", name="lostPasswordChangeSuccess", methods={"GET"}) */
    public function changePasswordSuccessAction(){
        return $this->render('pages/lost-password-change-success.html.twig');
    }

}