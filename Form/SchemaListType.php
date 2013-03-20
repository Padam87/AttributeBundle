<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class SchemaListType extends SchemaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('className', 'choice', array(
            'choices' => array_flip($this->config['class']),
            'required' => false
        ));
        $builder->remove('attributes');
        $builder->remove('groups');
    }
}
