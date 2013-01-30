<?php

namespace Padam87\AttributeBundle\Entity;

abstract class AbstractSchema
{
    public function applyTo($entity, $attributeClass, $groupClass = null)
    {
        foreach ($this->getAttributes() as $Attribute) {
            $exists = false;

            foreach ($entity->getAttributes() as $EntityAttribute) {
                if ($Attribute->getDefinition()->getId() == $EntityAttribute->getDefinition()->getId()) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $entity->addAttribute($this->transformAttribute($Attribute, $attributeClass));
            }
        }

        if ($groupClass != null) {
            foreach ($this->getGroups() as $Group) {
                $entity->addGroup($this->transformGroup($Group, $attributeClass, $groupClass));
            }
        }

        return $entity;
    }

    protected function transformAttribute($Attribute, $attributeClass)
    {
        $EntityAttribute = new $attributeClass();
        $EntityAttribute->setValue($Attribute->getValue());
        $EntityAttribute->setUnit($Attribute->getUnit());
        $EntityAttribute->setRequired($Attribute->getRequired());
        $EntityAttribute->setDefinition($Attribute->getDefinition());

        return $EntityAttribute;
    }

    protected function transformGroup($Group, $attributeClass, $groupClass)
    {
        $EntityGroup = new $groupClass();
        $EntityGroup->setDefinition($Group->getDefinition());

        foreach ($Group->getAttributes() as $Attribute) {
            $EntityGroup->addAttribute($this->transformAttribute($Attribute, $attributeClass));
        }

        return $EntityGroup;
    }
}
