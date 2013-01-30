<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="attribute_group")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"group" = "Group"})
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Schema", inversedBy="groups")
     * @ORM\JoinColumn(name="schema_id", referencedColumnName="id")
     * @var Schema
     */
    private $schema;

    /**
     * @ORM\OneToMany(targetEntity="Attribute", mappedBy="group", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $attributes;

    /**
     * @ORM\ManyToOne(targetEntity="GroupDefinition", inversedBy="groups", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="definition_id", referencedColumnName="id")
     * @var GroupDefinition
     */
    private $definition;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attributes
     *
     * @param  \Padam87\AttributeBundle\Entity\Attribute $attributes
     * @return Group
     */
    public function addAttribute($attributes)
    {
        $attributes->setGroup($this);
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Padam87\AttributeBundle\Entity\Attribute $attributes
     */
    public function removeAttribute($attributes)
    {
        $this->attributes->removeElement($attributes);
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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set schema
     *
     * @param  \Padam87\AttributeBundle\Entity\Schema $schema
     * @return Group
     */
    public function setSchema(\Padam87\AttributeBundle\Entity\Schema $schema = null)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get schema
     *
     * @return \Padam87\AttributeBundle\Entity\Schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Set definition
     *
     * @param  \Padam87\AttributeBundle\Entity\GroupDefinition $definition
     * @return Group
     */
    public function setDefinition(\Padam87\AttributeBundle\Entity\GroupDefinition $definition = null)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * Get definition
     *
     * @return \Padam87\AttributeBundle\Entity\GroupDefinition
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}
