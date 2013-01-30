<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DefinitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
        ));
        $builder->add('description', 'text', array(
            'required' => false
        ));
        $builder->add('type', 'choice', array(
            'choices'		=> array(
                'text'					=> 'text',
                'textarea'				=> 'textarea',
                'choice'				=> 'select',
                'checkbox'				=> 'checkbox',
                'radio'					=> 'radio',
            ),
        ));
        $builder->add('options', 'collection', array(
            'type'          => new OptionType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'by_reference'  => false,
            'options'       => array(
            ),
        ));
    }

    public function getName()
    {
        return 'attribute_definition';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\AttributeBundle\Entity\Definition',
        );
    }
}
