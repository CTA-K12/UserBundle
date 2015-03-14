<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResetRequestFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('credential', 'text', array('label' => 'Username', 'required' => true))
            ->add('request', 'submit', array('label' => 'Request Password Reset'))
        ;
    }


    public function getName()
    {
        return 'mesd_user_reset_request';
    }
}