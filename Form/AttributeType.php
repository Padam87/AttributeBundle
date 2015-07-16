<?php

namespace Padam87\AttributeBundle\Form;

use Padam87\AttributeBundle\Form\EventListener\AttributeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AttributeSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Padam87\AttributeBundle\Entity\Attribute',
        ]);
    }

    public function getName()
    {
        return 'attribute';
    }
}
