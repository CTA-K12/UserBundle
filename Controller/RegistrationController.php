<?php

namespace Mesd\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mesd\UserBundle\Form\Type\RegistrationFormType;

class RegistrationController extends Controller
{

    public function registerAction(Request $request)
    {
        $userManager = $this->container->get('mesd_user.user_manager');

        $user = $userManager->createUser();
        //$user->setEnabled(true);

        $form = $this->createForm(
            new RegistrationFormType(
                $this->container->getParameter('mesd_user.user_class')
                ),
            $user
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
        //$user->setEnabled(true);

        $form = new RegistrationFormType($this->container->getParameter('mesd_user.user_class'));

        $form->handle($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);
            return $response;
        }

        return $this->render(
            'MesdUserBundle:registration:register.html.twig',
            array('form' => $form->createView())
        );
    }


}