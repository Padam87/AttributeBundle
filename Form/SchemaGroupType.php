<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SchemaGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('groups', 'collection', array(
            'type'          => new GroupType(),
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
        return 'schema';
    }
}
