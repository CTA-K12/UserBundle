<?php

namespace Mesd\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mesd\UserBundle\Form\Type\RegistrationFormType;
use Mesd\UserBundle\Model\Mailer;

class RegistrationController extends Controller
{

    public function newAction(Request $request)
    {
        $userManager = $this->get('mesd_user.user_manager');

        $user = $userManager->createUser();
        //$user->setEnabled(true);

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


    public function createAction(Request $request)
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

        $form->handleRequest($request);

        $sendEmail = $this->container->getParameter('mesd_user.registration.mail_confirmation');

        if ($form->isValid()) {
            $userManager->updateUser($user);

            if (true === $sendEmail) {

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
                        'template' => $this->container->getParameter('mesd_user.registration.mail_template')
                    )
                );
            }

            return $this->render(
                $this->container->getParameter('mesd_user.registration.template.confirm'),
                array(
                    'form' => $form->createView(),
                    'send_mail' => $sendEmail
                )
            );
        }

        return $this->render(
            $this->container->getParameter('mesd_user.registration.template.register'),
            array('form' => $form->createView())
        );
    }


}