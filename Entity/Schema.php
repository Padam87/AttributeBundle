<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table("attribute_schema")
 */
class Schema
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $className;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Definition", mappedBy="schema", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"orderIndex" = "ASC"})
     */
    protected $definitions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->definitions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->className;
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
     * Add definitions
     *
     * @param \Padam87\AttributeBundle\Entity\Definition $definitions
     * @return AbstractSchema
     */
    public function addDefinition(\Padam87\AttributeBundle\Entity\Definition $definitions)
    {
        $definitions->setSchema($this);
        $this->definitions[] = $definitions;

        return $this;
    }

    /**
     * Remove definitions
     *
     * @param \Padam87\AttributeBundle\Entity\Definition $definitions
     */
    public function removeDefinition(\Padam87\AttributeBundle\Entity\Definition $definitions)
    {
        $this->definitions->removeElement($definitions);
    }

    /**
     * Get definitions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Set className
     *
     * @param string $className
     * @return Schema
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}
