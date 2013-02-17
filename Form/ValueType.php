<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Padam87\AttributeBundle\Form\EventListener\AttributeTypeSubscriber;

class ValueType extends AbstractType
{
    public function __construct($attributeOptions = array())
    {
        $this->attributeOptions = $attributeOptions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AttributeTypeSubscriber($builder->getFormFactory(), $this->attributeOptions);
        $builder->addEventSubscriber($subscriber);

        $builder->add('value', 'text', array(
            'required' => false
        ));
        $builder->add('attribute', 'entity', array(
            'class' => 'Padam87\AttributeBundle\Entity\Attribute'
        ));
    }

    public function getName()
    {
        return 'value';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\AttributeBundle\Entity\Value',
        );
    }
}
