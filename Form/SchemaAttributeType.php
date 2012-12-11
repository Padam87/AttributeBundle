<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class SchemaAttributeType extends AttributeType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        parent::buildForm($builder, $options);
        
		$builder->remove('value');
	}
}
