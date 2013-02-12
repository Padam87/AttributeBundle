<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class DefinitionListType extends DefinitionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', 'text', array(
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
            'required' => false
        ));
        $builder->remove('options');
    }
}
