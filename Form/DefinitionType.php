<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DefinitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
        ]);
        $builder->add('description', 'textarea', [
            'required' => false,
        ]);
        $builder->add('type', 'choice', [
            'choices' => [
                'text'      => 'Text',
                'textarea'  => 'Textarea',
                'choice'    => 'Select',
                'checkbox'  => 'Checkbox',
                'radio'     => 'Radio',
            ],
        ]);
        $builder->add('options', 'collection', [
            'type'          => new OptionType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'prototype'     => true,
            'by_reference'  => false,
            'options'       => [],
        ]);
        $builder->add('unit', 'text', [
            'required' => false,
        ]);
        $builder->add('required', 'checkbox', [
            'required' => false,
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Padam87\AttributeBundle\Entity\Definition',
        ]);
    }

    public function getName()
    {
        return 'definition';
    }
}
