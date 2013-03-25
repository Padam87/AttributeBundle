<?php

namespace Padam87\AttributeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
        ));
    }

    public function getName()
    {
        return 'group';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Padam87\AttributeBundle\Entity\Group',
        );
    }
}
