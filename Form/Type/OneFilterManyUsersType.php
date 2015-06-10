<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OneFilterManyUsersType extends AbstractType
{
    private $filterClassName;
    private $userClassName;
    private $queryBuilder;

    public function __construct(
        $filterClassName,
        $userClassName,
        $queryBuilder
    )
    {
        $this->filterClassName = $filterClassName;
        $this->userClassName = $userClassName;
        $this->queryBuilder = $queryBuilder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builderOptions = array(
            'class' => $this->userClassName,
            'multiple' => true,
            'expanded' => true,
            'by_reference' => false,
        );
        if (!is_null($this->queryBuilder)) {
            $builderOptions['query_builder'] = $this->queryBuilder;
        }
        $builder
            ->add(
                'user',
                'entity',
                $builderOptions
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