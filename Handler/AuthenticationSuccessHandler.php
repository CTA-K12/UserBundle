<?php

namespace Mesd\UserBundle\Handler;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManager;

// Source: http://stackoverflow.com/questions/10922516/symfony2-login-and-security
class AuthenticationSuccessHandler extends ContainerAware implements AuthenticationSuccessHandlerInterface
{
    private $om;

    public function __construct(EntityManager $om)
    {
        $this->om = $om;
    }

    function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $token->getUser()->setLastLogin(new \DateTime());
        $this->om->flush();
    }
}