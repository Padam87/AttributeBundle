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
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    use AttributedEntityTrait;
}
