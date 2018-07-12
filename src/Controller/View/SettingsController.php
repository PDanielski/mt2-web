<?php


namespace App\Controller\View;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SettingsController extends Controller {

    /** @Route("/settings", name="getSettingsAction") */
    public function indexAction(){

    }

    /** @Route("/settings/change-password", name="getChangePasswordAction") */
    public function changePasswordAction(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('pages/settings/change-password.settings.html.twig');
    }

    /** @Route("/settings/change-password/success", name="getChangePasswordSuccessAction") */
    public function changePasswordSuccessAction() {
        return $this->render('pages/settings/change-password-success.settings.html.twig');
    }

    /** @Route("/settings/change-email", name="getChangeEmailAction") */
    public function changeEmailAction(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('pages/settings/change-email.settings.html.twig');
    }

    /** @Route("/settings/change-email/success", name="getChangeEmailSuccessAction") */
    public function changeEmailSuccessAction(){
        return $this->render('pages/settings/change-email-success.settings.html.twig');
    }

}