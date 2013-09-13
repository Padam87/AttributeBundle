<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Padam87\AttributeBundle\Form\EventListener\AttributeSubscriber;

class CompleteAttributeType extends AttributeType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('definition', new DefinitionType(), array(

        ));
    }
}
