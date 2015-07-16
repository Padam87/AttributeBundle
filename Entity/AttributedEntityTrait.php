<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait AttributedEntityTrait
{
    /**
     * @var Collection
     *
     * @ORM\ManyToMany(
     *     targetEntity="\Padam87\AttributeBundle\Entity\Attribute",
     *     fetch="EAGER",
     *     cascade={"persist", "remove"}
     * )
     */
    private $attributes;

    /**
     * @param Attribute $attributes
     *
     * @return $this
     */
    public function addAttribute(Attribute $attributes)
    {
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * @param Attribute $attributes
     */
    public function removeAttribute(Attribute $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * @return Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
