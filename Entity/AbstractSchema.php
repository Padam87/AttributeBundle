<?php

namespace Padam87\AttributeBundle\Entity;

abstract class AbstractSchema
{
    public function applyTo($entity, $attributeClass)
    {
        foreach ($this->getAttributes() as $Attribute) {
            $exists = false;
            
            foreach ($entity->getAttributes() as $EntityAttribute) {
                if($Attribute->getDefinition()->getId() == $EntityAttribute->getDefinition()->getId()) {
                    $exists = true;
                    break;
                }
            }
            
            if(!$exists) {
                $entity->addAttribute($this->transformAttribute($Attribute, $attributeClass));
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
}