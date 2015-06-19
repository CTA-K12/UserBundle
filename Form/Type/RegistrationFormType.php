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
            ->add('username', null, array())
            ->add('email', 'repeated', array(
                'type'            => 'email',
                'first_options'   => array(),
                'second_options'  => array(),
                'invalid_message' => 'emails.do.not.match'
                )
            )
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array(),
                'second_options'  => array(),
                'invalid_message' => 'passwords.do.not.match'
                )
            )
            ->add('save', 'submit', array())
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