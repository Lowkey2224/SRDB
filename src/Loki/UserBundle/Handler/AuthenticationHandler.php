<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 13.02.14
 * Time: 09:55
 */

namespace Loki\UserBundle\Handler;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface,
    LogoutSuccessHandlerInterface, AuthenticationFailureHandlerInterface{

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = new RedirectResponse($this->router->generate(
            'loki_character_login_failure'
        ));
        return $response;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //Falls wir redirects, abhängig vom Rang machen wollen
//        if ($this->security->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('loki_character_index'));
//        }
        return $response;
    }

    /**
     * Creates a Response object to send upon a successful logout.
     *
     * @param Request $request
     *
     * @return Response never null
     */
    public function onLogoutSuccess(Request $request)
    {
        $referer_url = $request->headers->get('referer');

        return new RedirectResponse($referer_url);
    }
}