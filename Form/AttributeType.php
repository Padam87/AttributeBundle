<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AttributeType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $subscriber = new EventListener\AttributeTypeSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
        
		$builder->add('definition', 'entity', array(
            'class' => 'Padam87\AttributeBundle\Entity\Definition'
		));
		$builder->add('value', 'text', array(
            'required' => false
		));
		$builder->add('unit', 'text', array(
            'required' => false
		));
		$builder->add('required', 'checkbox', array(
            'required' => false
		));
	}

	public function getName()
	{
		return 'attribute_option';
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'Padam87\AttributeBundle\Entity\Attribute',
		);
	}
}
