<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OneFilterManyUsersType extends AbstractType
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
                    'label' => 'Users',
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
        return 'mesd_one_user_many_filters';
    }
}