<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("attribute")
 */
class Attribute
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var Definition
     *
     * @ORM\ManyToOne(targetEntity="Definition", inversedBy="attributes")
     * @ORM\JoinColumn(name="definition_id", referencedColumnName="id", nullable=false)
     */
    private $definition;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDefinition()->getName();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $value
     *
     * @return Attribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param Definition $definition
     *
     * @return Attribute
     */
    public function setDefinition(Definition $definition = null)
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * @return Definition
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}
