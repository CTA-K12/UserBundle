<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewPasswordFormType extends AbstractType
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', 'repeated', array(
            'type'            => 'password',
            'first_options'   => array('label' => 'Password'),
            'second_options'  => array('label' => 'Password Confirmation'),
            'invalid_message' => 'Password Mismatch',
            ))
            ->add('reset', 'submit', array('label' => 'Reset Password'));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }
    public function getName()
    {
        return 'mesd_user_new_password';
    }
}