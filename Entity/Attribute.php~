<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_schema_attribute")
 * @UniqueEntity({"definition", "schema"})
 */
class Attribute extends AbstractAttribute
{
    /**
     * @ORM\ManyToOne(targetEntity="Schema", inversedBy="attributes")
     * @ORM\JoinColumn(name="schema_id", referencedColumnName="id")
     * @var Schema
     */
    private $schema;

    /**
     * Set schema
     *
     * @param \Padam87\AttributeBundle\Entity\Schema $schema
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