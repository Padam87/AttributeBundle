<?php

namespace Padam87\AttributeBundle\Tests\Model;

use Doctrine\ORM\Mapping as ORM;
use Padam87\AttributeBundle\Annotation as EAV;
use Padam87\AttributeBundle\Entity\AttributedEntityTrait;

/**
 * @ORM\Entity()
 * @EAV\Entity()
 */
class Subscriber
{
    use AttributedEntityTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
}
