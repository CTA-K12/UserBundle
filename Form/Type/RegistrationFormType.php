<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('label' => 'form.email'))
            ->add('username', null, array('label' => 'form.username'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                //'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                )
            )
            ->add('save', 'submit', array('label' => 'Create Account'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

    public function getName()
    {
        return 'mesd_user_registration';
    }
}