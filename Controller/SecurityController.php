<?php

namespace Mesd\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // Check if security context is already authenticated
        if (true === $this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $revisitBehavior = $this->container
                ->getParameter('mesd_user.login.revisit_behavior');

            if ('logout' === $revisitBehavior) {
                return $this->redirect($this->generateUrl('MesdUserBundle_logout'));
            }

            if ('redirect' === $revisitBehavior) {
                $revisitTarget = $this->container
                ->getParameter('mesd_user.login.revisit_redirect_target');
                return $this->redirect($this->generateUrl($revisitTarget));
            }
        }

        // Check for errors
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = null;
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        // check if credentials have expired
        if ($error instanceof CredentialsExpiredException) {

            $manager = $this->get('mesd_user.user_manager');
            $user = $manager->findOneByUsernameOrEmail($lastUsername);

            //var_dump($user);exit;
            if ($user) {
                $user->generateConfirmationToken();
                $user->setPasswordRequestedAt(new \DateTime());
                $manager->updateUser($user);

                $request->getSession()->getFlashBag()->add(
                    'danger',
                    $this->get('translator')->trans('user.credentials.expired.create.new.password.required')
                );
        
                return $this->redirect($this->generateUrl('MesdUserBundle_reset_new_password', array(
                    'token' => $user->getConfirmationToken(),
                )));
            }
        }

        if (!$error instanceof AuthenticationException) {
            $error = null;
        }


        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

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