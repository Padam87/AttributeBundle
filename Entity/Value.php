<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
class Value
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var integer
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute", inversedBy="attributes")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     * @var Schema
     */
    private $attribute;

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
    * Set value
    *
    * @param string $value
    * @return AbstractAttribute
    */
    public function setValue($value)
    {
        if ($this->getAttribute() != NULL &&
                $this->getAttribute()->getDefinition() != NULL &&
                $this->getAttribute()->getDefinition()->getType() == 'checkbox') {

            $value = serialize($value);
        }

        $this->value = $value;

        return $this;
    }

    /**
    * Get value
    *
    * @return string
    */
    public function getValue()
    {
        if ($this->getAttribute() != NULL &&
                $this->getAttribute()->getDefinition() != NULL &&
                $this->getAttribute()->getDefinition()->getType() == 'checkbox') {

            if ($this->value) {
                $value = @unserialize($this->value);
            } else {
                $value = array();
            }

        } else {
            $value = $this->value;
        }

        return $value;
    }

    /**
     * Set attribute
     *
     * @param  \Padam87\AttributeBundle\Entity\Attribute $attribute
     * @return Value
     */
    public function setAttribute(\Padam87\AttributeBundle\Entity\Attribute $attribute = null)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return \Padam87\AttributeBundle\Entity\Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
