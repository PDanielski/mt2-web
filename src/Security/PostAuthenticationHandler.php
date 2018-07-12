<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class PostAuthenticationHandler implements AuthenticationFailureHandlerInterface, AuthenticationSuccessHandlerInterface {
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        return new Response("", 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        return new Response("", 200);
    }

}