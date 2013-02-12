<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="attribute_group")
 * @UniqueEntity({"name", "schema"})
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
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

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
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param  string $name
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Add attributes
     *
     * @param  \Padam87\AttributeBundle\Entity\Attribute $attributes
     * @return Group
     */
    public function addAttribute(\Padam87\AttributeBundle\Entity\Attribute $attributes)
    {
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Padam87\AttributeBundle\Entity\Attribute $attributes
     */
    public function removeAttribute(\Padam87\AttributeBundle\Entity\Attribute $attributes)
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
}
