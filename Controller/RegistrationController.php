<?php

namespace Mesd\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mesd\UserBundle\Form\Type\RegistrationFormType;
use Mesd\UserBundle\Model\Mailer;

class RegistrationController extends Controller
{


    // Override setContainer so we can determine if registration is
    // enabled before running any controller actions.
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        // If registration is not enabled, throw page not found error
        if (false === $this->container->getParameter('mesd_user.registration.enabled')) {
            throw $this->createNotFoundException();
        }
    }


    public function createAction(Request $request)
    {
        $userManager = $this->get('mesd_user.user_manager');
        $user = $userManager->createUser();

        $requireAdminApproval  = $this->container->getParameter('mesd_user.registration.approval_required');
        $sendConfirmationEmail = $this->container->getParameter('mesd_user.registration.mail_confirmation');

        if (true === $sendConfirmationEmail || true === $requireAdminApproval) {
            $user->setEnabled(false);
        }

        $form = $this->createForm(
            new RegistrationFormType(
                    $this->container->getParameter('mesd_user.user_class')
            ),
            $user,
            array(
                'action' => $this->generateUrl('MesdUserBundle_registration_create'),
                'method' => 'POST',
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            if (true === $sendConfirmationEmail) {
                $user->generateConfirmationToken();
                $userManager->updateUser($user);
                $mailer = new Mailer(
                    $this->get('mailer'),
                    $this->get('router'),
                    $this->get('templating')
                );

                $mailer->sendConfirmationEmailMessage(
                    $user,
                    array(
                        'from'     => $this->container->getParameter('mesd_user.registration.mail_from'),
                        'to'       => $user->getEmail(),
                        'subject'  => $this->container->getParameter('mesd_user.registration.mail_subject'),
                        'template' => $this->container->getParameter('mesd_user.registration.template.confirm_mail')
                    )
                );
            }

            return $this->render(
                $this->container->getParameter('mesd_user.registration.template.summary'),
                array(
                    'form' => $form->createView(),
                    'send_mail' => $sendConfirmationEmail
                )
            );
        }

        return $this->render(
            $this->container->getParameter('mesd_user.registration.template.register'),
            array('form' => $form->createView())
        );
    }


    public function confirmAction($token)
    {
        $message = 'Account not found';

        $userManager = $this->get('mesd_user.user_manager');
        $user = $userManager->findUserByConfirmationToken($token);

        $message = 'Your account has been confirmed.';

        if ($user && null !== $user) {
            if (false === $this->container->getParameter('mesd_user.registration.approval_required')) {
                $user->setEnabled(true);
            } else {
                $message .= ' However, it remains disabled until approved by an administrator.';
            }
            $user->setConfirmationToken(null);
            $userManager->updateUser($user);
        }

        return $this->render(
            $this->container->getParameter('mesd_user.registration.template.confirm'),
            array(
                'message' => $message
            )
        );
    }


    public function newAction()
    {
        $userManager = $this->get('mesd_user.user_manager');

        $user = $userManager->createUser();

        $form = $this->createForm(
            new RegistrationFormType(
                $this->container->getParameter('mesd_user.user_class')
                ),
            $user,
            array(
                'action' => $this->generateUrl('MesdUserBundle_registration_create'),
                'method' => 'POST',
            )
        );

        return $this->render(
            $this->container->getParameter('mesd_user.registration.template.register'),
            array('form' => $form->createView())
        );
    }


}