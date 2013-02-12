<?php

namespace Padam87\AttributeBundle\Entity;

abstract class AbstractSchema
{
    public function applyTo($entity, $attributeClass)
    {
        foreach ($this->getAttributes() as $attribute) {
            $targetAttribute = null;

            foreach ($entity->getAttributes() as $entityAttribute) {
                if ($attribute->getDefinition()->getId() == $entityAttribute->getDefinition()->getId() &&
                        $attribute->getGroup() == $entityAttribute->getGroup() ) {
                    $targetAttribute = $entityAttribute;
                    break;
                }
            }

            if ($targetAttribute == null) {
                $entity->addAttribute($this->transformAttribute($attribute, $attributeClass));
            } else {
                $targetAttribute->setUnit($attribute->getUnit());
                $targetAttribute->setRequired($attribute->getRequired());
                $targetAttribute->setGroup($attribute->getGroup());
            }
        }

        foreach ($entity->getAttributes() as $entityAttribute) {
            $exists = false;
            foreach ($this->getAttributes() as $attribute) {
                if ($attribute->getDefinition()->getId() == $entityAttribute->getDefinition()->getId() &&
                        $attribute->getGroup() == $entityAttribute->getGroup() ) {
                    $exists = true;
                    break;
                }
            }

            if ($exists == false) {
                $entity->removeAttribute($entityAttribute);
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
        $EntityAttribute->setGroup($Attribute->getGroup());

        return $EntityAttribute;
    }
}
