<?php


namespace App\Controller\View;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RegistrationController extends Controller {

    /**
     * @Route("/registration", name="registration")
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @return Response
     */
    public function indexAction(AuthorizationCheckerInterface $authorizationChecker) {
        /*if($authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->redirectToRoute('homepage');*/
        return $this->render('pages/registration.html.twig');
    }

    /**
     * @Route("/registration/success", name="registrationSuccess")
     */
    public function successAction(){
        return $this->render('pages/registration-success.html.twig');
    }

}