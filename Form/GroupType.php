<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('definition', new GroupDefinitionType(), array(
        ));
        $builder->add('attributes', 'collection', array(
            'type'          => new AttributeType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'prototype_name'=> '__groupid__',
            'by_reference'  => false,
            'options'       => array(
            ),
        ));
    }

    public function getName()
    {
        return 'attribute_group';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\AttributeBundle\Entity\Group',
        );
    }
}
