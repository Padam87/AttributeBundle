<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('definition', 'entity', array(
            'class' => 'Padam87\AttributeBundle\Entity\Definition'
        ));
        $builder->add('unit', 'text', array(
            'required' => false
        ));
        $builder->add('required', 'checkbox', array(
            'required' => false
        ));
        $builder->add('orderIndex', 'text', array(
            'required' => true
        ));
        $builder->add('group', 'entity', array(
            'class' => 'Padam87\AttributeBundle\Entity\Group',
            'required' => false
        ));
    }

    public function getName()
    {
        return 'attribute';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\AttributeBundle\Entity\Attribute',
        );
    }
}
