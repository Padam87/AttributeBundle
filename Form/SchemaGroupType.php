<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class SchemaGroupType extends GroupType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        parent::buildForm($builder, $options);
        
		$builder->remove('attributes')->add('attributes', 'collection', array(
			'type'          => new SchemaAttributeType(),
			'allow_add'     => true,
			'allow_delete'  => true,
			'prototype'     => true,
            'prototype_name'=> '__groupid__',
			'by_reference'  => false,
			'options'       => array(
			),
		));;
	}
}
