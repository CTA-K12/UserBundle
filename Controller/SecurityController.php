<?php

namespace Mesd\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\AuthenticationEvents;



class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {

        $session = $request->getSession();

        $authenticationUtils = $this->get('security.authentication_utils');

        // Check if security context is already authenticated
        if (true === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $revistBehavior = $this->container
                ->getParameter('mesd_user.login.revisit_behavior');

            if ('logout' === $revistBehavior) {
                return $this->redirect($this->generateUrl('MesdUserBundle_logout'));
            }

            if ('redirect' === $revistBehavior) {
                $revistTarget = $this->container
                ->getParameter('mesd_user.login.revisit_redirect_target');
                return $this->redirect($this->generateUrl($revistTarget));
            }
        }

        // Check for errors
        if ($request->attributes->has(AuthenticationEvents::AUTHENTICATION_FAILURE)) {
            $error = $request->attributes->get(AuthenticationEvents::AUTHENTICATION_FAILURE);
        } elseif (null !== $session && $session->has(AuthenticationEvents::AUTHENTICATION_FAILURE)) {
            $error = $session->get(AuthenticationEvents::AUTHENTICATION_FAILURE);
            $session->remove(AuthenticationEvents::AUTHENTICATION_FAILURE);
        } else {
            $error = null;
        }

        // Ensure that the error came from the security component
        if (!$error instanceof AuthenticationException) {
            $error = null;
        }

        // Get last username entered by the user
        $lastUsername = (null === $session) ? '' : $authenticationUtils->getLastUsername();

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        print('before render');

        return $this->render(
            $this->container->getParameter('mesd_user.login.template'),
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                'csrf_token'    => $csrfToken
            )
        );
    }


    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }


    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}