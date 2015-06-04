<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OneFilterManyUsersType extends AbstractType
{
    private $filterClassName;
    private $userClassName;

    public function __construct($filterClassName, $userClassName)
    {
        $this->filterClassName = $filterClassName;
        $this->userClassName = $userClassName;
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
                    'multiple' => true,
                    'expanded' => true,
                    'by_reference' => false,
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
        return 'mesd_user_one_filter_many_users';
    }
}