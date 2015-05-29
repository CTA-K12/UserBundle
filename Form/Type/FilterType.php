<?php

namespace Mesd\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilterType extends AbstractType
{
    private $filterClassName;
    private $filterCategoryClassName;

    public function __construct($filterClassName, $filterCategoryClassName)
    {
        $this->filterClassName = $filterClassName;
        $this->filterCategoryClassName = $filterCategoryClassName;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'filterCategory',
                'entity',
                array(
                    'class' => $this->filterCategoryClassName,
                    'label' => 'Category',
                    'required' => true,
                    'empty_value' => '',
                )
            )
            ->add('name')
            ->add(
                'solvent',
                'hidden',
                array(
                    'attr' => array(
                        'class' => 'filter-solvent-hidden',
                    ),
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
        return 'mesd_filter';
    }
}