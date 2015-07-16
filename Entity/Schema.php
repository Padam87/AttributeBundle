<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table("attribute_schema")
 */
class Schema
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $className;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Definition", mappedBy="schema", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"orderIndex" = "ASC"})
     */
    protected $definitions;

    public function __construct()
    {
        $this->definitions = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->className;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Definition $definition
     *
     * @return Schema
     */
    public function addDefinition(Definition $definition)
    {
        $definition->setSchema($this);
        $this->definitions[] = $definition;

        return $this;
    }

    /**
     * @param Definition $definitions
     */
    public function removeDefinition(Definition $definitions)
    {
        $this->definitions->removeElement($definitions);
    }

    /**
     * @return ArrayCollection
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param string $className
     *
     * @return Schema
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}
