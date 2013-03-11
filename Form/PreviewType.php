<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PreviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('attributeValues', 'collection', array(
            'type'          => new ValueType(),
            'allow_add'     => false,
            'allow_delete'  => false,
            'prototype'     => false,
            'by_reference'  => false,
            'options'       => array(
            ),
        ));
    }

    public function getName()
    {
        return 'attribute';
    }
}
