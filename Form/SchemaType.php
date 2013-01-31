<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SchemaType extends AbstractType
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config['schema'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
        ));
        $builder->add('class', 'choice', array(
            'choices' => array_flip($this->config['class'])
        ));
        $builder->add('attributes', 'collection', array(
            'type'          => new SchemaAttributeType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'by_reference'  => false,
            'options'       => array(
            ),
        ));
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

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\AttributeBundle\Entity\Schema',
        );
    }
}
