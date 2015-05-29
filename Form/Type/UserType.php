<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
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
        $builder->add(
            'filter',
            'entity',
            array(
                'class' => $this->filterClassName,
                'expanded' => true,
                'multiple' => true,
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->userClassName
        ));
    }

    public function getName()
    {
        return 'mesd_user';
    }
}