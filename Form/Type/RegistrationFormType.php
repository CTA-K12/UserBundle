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
            ->add('username', null, array('label' => 'Username'))
            ->add('email', 'repeated', array(
                'type'            => 'email',
                'first_options'   => array('label' => 'Email'),
                'second_options'  => array('label' => 'Email Confirmation'),
                'invalid_message' => 'Email Mismatch'
                )
            )
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array('label' => 'Password'),
                'second_options'  => array('label' => 'Password Confirmation'),
                'invalid_message' => 'Password Mismatch'
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