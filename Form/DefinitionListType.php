<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class DefinitionListType extends DefinitionType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        parent::buildForm($builder, $options);
        
		$builder->get('name')->setRequired(false);
		$builder->get('description')->setRequired(false);
		$builder->get('type')->setRequired(false);
		$builder->remove('options');
	}
}
