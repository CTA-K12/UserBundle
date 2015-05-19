<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilterType extends AbstractType
{
    private $filterClassName;
    private $userClassName;
    private $roleClassName;

    public function __construct($filterClassName, $userClassName, $roleClassName)
    {
        $this->filterClassName = $filterClassName;
        $this->userClassName = $userClassName;
        $this->roleClassName = $roleClassName;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                'entity',
                array(
                    'class' => $this->userClassName,
                    'label' => 'User',
                    'required' => true,
                    'empty_value' => '',
                )
            )
            ->add(
                'role',
                'entity',
                array(
                    'class' => $this->roleClassName,
                    'label' => 'Role',
                    'required' => true,
                    'empty_value' => '',
                )
            )
            ->add(
                'request',
                'submit',
                array(
                    'label' => 'Submit'
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->filterClassName
        ));
    }

    public function getName()
    {
        return 'mesd_user_filter';
    }
}