<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilterType extends AbstractType
{
    private $userClassName;
    private $filterClassName;

    public function __construct($userClassName, $filterClassName)
    {
        $this->userClassName = $userClassName;
        $this->filterClassName = $filterClassName;
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
                'filter',
                'entity',
                array(
                    'class' => $this->filterClassName,
                    'label' => 'Filter',
                    'required' => true,
                    'empty_value' => '',
                )
            )
        ;
    }

    public function getName()
    {
        return 'mesd_user_filter';
    }
}