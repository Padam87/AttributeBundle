<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait AttributedEntityTrait
{
    /**
     * @var \Padam87\AttributeBundle\Entity\Attribute
     *
     * @ORM\ManyToMany(targetEntity="\Padam87\AttributeBundle\Entity\Attribute", fetch="EAGER", cascade={"persist", "remove"})
     */
    private $attributes;

    /**
     * Add attributes
     *
     * @param \Padam87\AttributeBundle\Entity\Attribute $attribute
     */
    public function addAttribute(\Padam87\AttributeBundle\Entity\Attribute $attribute)
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Padam87\AttributeBundle\Entity\Attribute $attribute
     */
    public function removeAttribute(\Padam87\AttributeBundle\Entity\Attribute $attribute)
    {
        $this->attributes->removeElement($attribute);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
