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

            // Determine if approval notice should be
            // displayed to user, default to false.
            $approval = false;

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
                        'subject'  => $this->container->getParameter('mesd_user.registration.mail_subject'),
                        'template' => $this->container->getParameter('mesd_user.registration.template.confirm_mail')
                    )
                );
            } elseif (true === $requireAdminApproval) {
                if (true === $this->container->getParameter('mesd_user.registration.approval_mail')) {
                    $user->generateConfirmationToken();
                    $userManager->updateUser($user);
                    $mailer = new Mailer(
                        $this->get('mailer'),
                        $this->get('router'),
                        $this->get('templating')
                    );

                    $mailer->sendApprovalEmailMessage(
                        $user,
                        array(
                            'from'     => $this->container->getParameter('mesd_user.registration.approval_mail_from'),
                            'to'       => $this->container->getParameter('mesd_user.registration.approval_mail_to'),
                            'subject'  => $this->container->getParameter('mesd_user.registration.approval_mail_subject'),
                            'template' => $this->container->getParameter('mesd_user.registration.template.approval_mail')
                        )
                    );
                }

                // Display notice that user approval is needed
                $approval = true;
            }

            return $this->render(
                $this->container->getParameter('mesd_user.registration.template.summary'),
                array(
                    'form' => $form->createView(),
                    'send_mail' => $sendConfirmationEmail,
                    'approval'  => $approval
                )
            );
        }

        return $this->render(
            $this->container->getParameter('mesd_user.registration.template.register'),
            array('form' => $form->createView())
        );
    }


    public function approveAction($token)
    {
        $message = 'Account not found';

        $userManager = $this->get('mesd_user.user_manager');
        $user = $userManager->findUserByConfirmationToken($token);

        if ($user && null !== $user) {
            $message = 'Account has been approved.';
            $user->setConfirmationToken(null);
            $user->setEnabled(true);
            $userManager->updateUser($user);
        }

        return $this->render(
            $this->container->getParameter('mesd_user.registration.template.approve'),
            array(
                'message' => $message
            )
        );
    }


    public function confirmAction($token)
    {
        $message = 'Account not found';

        $userManager = $this->get('mesd_user.user_manager');
        $user = $userManager->findUserByConfirmationToken($token);

        if ($user && null !== $user) {
            $message = 'Your account has been confirmed.';
            $user->setConfirmationToken(null);

            if (false === $this->container->getParameter('mesd_user.registration.approval_required')) {
                $user->setEnabled(true);
            } else {
                $message .= ' However, it remains disabled until approved by an administrator.';

                if (true === $this->container->getParameter('mesd_user.registration.approval_mail')) {
                    $user->generateConfirmationToken();
                    $mailer = new Mailer(
                        $this->get('mailer'),
                        $this->get('router'),
                        $this->get('templating')
                    );

                    $mailer->sendApprovalEmailMessage(
                        $user,
                        array(
                            'from'     => $this->container->getParameter('mesd_user.registration.approval_mail_from'),
                            'to'       => $this->container->getParameter('mesd_user.registration.approval_mail_to'),
                            'subject'  => $this->container->getParameter('mesd_user.registration.approval_mail_subject'),
                            'template' => $this->container->getParameter('mesd_user.registration.template.approval_mail')
                        )
                    );
                }
            }

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