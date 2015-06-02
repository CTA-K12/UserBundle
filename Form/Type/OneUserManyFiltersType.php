<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OneUserManyFiltersType extends AbstractType
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
                'filter',
                'entity',
                array(
                    'class' => $this->filterClassName,
                    'label' => 'Filters',
                    'multiple' => true,
                    'expanded' => true,
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->userClassName
        ));
    }

    public function getName()
    {
        return 'mesd_one_user_many_filters';
    }
}