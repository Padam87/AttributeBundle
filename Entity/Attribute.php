<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute")
 */
class Attribute
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $unit;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $required = FALSE;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var string
     */
    private $orderIndex;

    /**
     * @ORM\ManyToOne(targetEntity="Definition", inversedBy="attributes", fetch="EAGER")
     * @ORM\JoinColumn(name="definition_id", referencedColumnName="id")
     * @var Definition
     */
    private $definition;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="attributes")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @var Group
     */
    private $group;

    /**
     * @ORM\ManyToOne(targetEntity="Schema", inversedBy="attributes")
     * @ORM\JoinColumn(name="schema_id", referencedColumnName="id")
     * @var Schema
     */
    private $schema;

    public function __toString()
    {
        return ($this->getGroup() != NULL ? $this->getGroup()->getName() . " - " : "") . $this->getDefinition()->getName();
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
     * Set unit
     *
     * @param  string    $unit
     * @return Attribute
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set required
     *
     * @param  boolean   $required
     * @return Attribute
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set orderIndex
     *
     * @param  integer   $orderIndex
     * @return Attribute
     */
    public function setOrderIndex($orderIndex)
    {
        $this->orderIndex = $orderIndex;

        return $this;
    }

    /**
     * Get orderIndex
     *
     * @return integer
     */
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * Set definition
     *
     * @param  \Padam87\AttributeBundle\Entity\Definition $definition
     * @return Attribute
     */
    public function setDefinition(\Padam87\AttributeBundle\Entity\Definition $definition = null)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * Get definition
     *
     * @return \Padam87\AttributeBundle\Entity\Definition
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Set group
     *
     * @param  \Padam87\AttributeBundle\Entity\Group $group
     * @return Attribute
     */
    public function setGroup(\Padam87\AttributeBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Padam87\AttributeBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set schema
     *
     * @param  \Padam87\AttributeBundle\Entity\Schema $schema
     * @return Attribute
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
}
