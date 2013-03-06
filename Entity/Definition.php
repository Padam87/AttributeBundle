<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_definition")
 */
class Definition
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
     * @ORM\Column(type="text", nullable=true)
     * @var text
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Option", mappedBy="definition", orphanRemoval=true, cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     * @var ArrayCollection
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity="Attribute", mappedBy="definition", cascade={"persist", "remove"})
     */
    protected $attributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        $getter = "get" . ucfirst($name);

        return $this->$getter();
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
     * @param  string     $name
     * @return Definition
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
     * Set description
     *
     * @param  string     $description
     * @return Definition
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param  string     $type
     * @return Definition
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add options
     *
     * @param  Padam87\AttributeBundle\Entity\Option $options
     * @return Definition
     */
    public function addOption(\Padam87\AttributeBundle\Entity\Option $options)
    {
        $options->setDefinition($this);
        $this->options[] = $options;

        return $this;
    }

    /**
     * Remove options
     *
     * @param Padam87\AttributeBundle\Entity\Option $options
     */
    public function removeOption(\Padam87\AttributeBundle\Entity\Option $options)
    {
        $this->options->removeElement($options);
    }

    /**
     * Get options
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Add attributes
     *
     * @param  \Padam87\AttributeBundle\Entity\Attribute $attributes
     * @return Definition
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
