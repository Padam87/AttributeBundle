<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_definition")
 */
class Definition
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unit;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $required = false;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderIndex;

    /**
     * @var Schema
     *
     * @ORM\ManyToOne(targetEntity="Schema", inversedBy="definitions")
     * @ORM\JoinColumn(name="schema_id", referencedColumnName="id")
     */
    private $schema;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Option",
     *     mappedBy="definition",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"},
     *     fetch="EXTRA_LAZY"
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $options;

    /**
     * @var Attribute
     *
     * @ORM\OneToMany(
     *     targetEntity="\Padam87\AttributeBundle\Entity\Attribute",
     *     mappedBy="definition",
     *     cascade={"remove"}
     * )
     */
    private $attributes;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $unit
     *
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param boolean $required
     *
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param integer $orderIndex
     *
     * @return $this
     */
    public function setOrderIndex($orderIndex)
    {
        $this->orderIndex = $orderIndex;

        return $this;
    }

    /**
     * @return integer
     */
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * @param Schema $schema
     *
     * @return $this
     */
    public function setSchema(Schema $schema = null)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get schema
     *
     * @return Schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param Option $option
     *
     * @return $this
     */
    public function addOption(Option $option)
    {
        $this->options[] = $option;
        $option->setDefinition($this);

        return $this;
    }

    /**
     * @param Option $options
     */
    public function removeOption(Option $options)
    {
        $this->options->removeElement($options);
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions()
    {
        return $this->options;
    }

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
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
