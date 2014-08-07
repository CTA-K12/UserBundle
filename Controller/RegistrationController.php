<?php

namespace Mesd\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mesd\UserBundle\Form\Type\RegistrationFormType;

class RegistrationController extends Controller
{

    public function newAction(Request $request)
    {
        $userManager = $this->container->get('mesd_user.user_manager');

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
            'MesdUserBundle:registration:register.html.twig',
            array('form' => $form->createView())
            );
    }


    public function createAction(Request $request)
    {
        $userManager = $this->container->get('mesd_user.user_manager');
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

        if ($form->isValid()) {
            $userManager->updateUser($user);

            return $this->render(
                'MesdUserBundle:registration:confirm.html.twig',
                array('form' => $form->createView())
            );
        }

        return $this->render(
            'MesdUserBundle:registration:register.html.twig',
            array('form' => $form->createView())
        );
    }


}