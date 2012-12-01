<?php

namespace Padam87\AttributeBundle\Entity;

abstract class AbstractSchema
{
    public function applyTo($entity, $attributeClass)
    {
        foreach ($entity->getAttributes() as $Attribute) {
            $entity->removeAttribute($Attribute);
        }
        
        foreach ($this->getAttributes() as $Attribute) {
            $entity->addAttribute($this->transformAttribute($Attribute, $attributeClass));
        }
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
}