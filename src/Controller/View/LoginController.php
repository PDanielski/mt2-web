<?php


namespace App\Controller\View;


use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginController extends Controller {

    use TargetPathTrait;

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $utils
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @return Response
     */
    public function loginAction(
        Request $request,
        AuthenticationUtils $utils,
        AuthorizationCheckerInterface $authorizationChecker
    ){
        if($authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        $redirect = $request->query->get('redirect');
        if (!$redirect) {
            $redirect = $this->getTargetPath($request->getSession(), 'main');
        }

        return $this->render('pages/login.html.twig', [
            'error' => $utils->getLastAuthenticationError(),
            'loginUrl' => $request->getRequestUri(),
            'successUrl' => $redirect ?: $this->generateUrl('homepage')
        ]);
    }

    /**
     * @Route("/is-login", name="itemshop_login")
     * @param Request $request
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @return Response
     */
    public function itemshopLogin(Request $request, AuthorizationCheckerInterface $authorizationChecker) {
        if(!$authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $redirect = $request->query->get('redirect');
        if(!$redirect) {
            throw new BadRequestHttpException();
        }

        $secret = '^9pu4)F0HemHqW5JQsdu(rV91H@0QL1rq$7Fo-n%';
        $hasQuery = parse_url($redirect, PHP_URL_QUERY) != "";

        if($hasQuery) {
            $sep = '&';
        } else {
            $sep = '?';
        }

        $token = JWT::encode(["accountID"], $secret);
        $redirect .= $sep;
        $redirect .= "token=".$token;
        return $this->redirect($redirect);
    }


}