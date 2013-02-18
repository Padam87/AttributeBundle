<?php

namespace Padam87\AttributeBundle\Listener;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Padam87\AttributeBundle\Entity\Schema;

/**
 * @DI\DoctrineListener(
 *     events = {"onFlush", "postFlush"},
 *     connection = "default"
 * )
 */
class SchemaListener
{
    protected $_em;
    
    protected $schema = null;

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $this->_em = $eventArgs->getEntityManager();
        $this->_uow = $this->_em->getUnitOfWork();
        
        foreach ($this->_uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Schema) {
                $this->schema = $entity;
            }
        }
        
        foreach ($this->_uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Schema) {
                $this->schema = $entity;
            }
        }
    }

    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        $this->_em = $eventArgs->getEntityManager();

        if ($this->schema != null) {
            $this->orderSchema($this->schema);
        }
    }

    protected function orderSchema($schema)
    {
        $grouped = array(
            0 => array()
        );

        foreach ($schema->getAttributes() as $attribute) {
            $group = $attribute->getGroup() === null ? 0 : $attribute->getGroup()->getId();

            if (!isset($grouped[$group])) {
                $grouped[$group] = array();
            }

            $grouped[$group][] = $attribute;
        }

        $i = 1;

        foreach ($grouped as $group) {
            foreach ($group as $attribute) {
                $attribute->setOrderIndex($i);

                $this->_em->persist($attribute);
                $this->_em->flush($attribute);

                $i++;
            }
        }

        $this->_em->persist($schema);
        $this->_em->flush($schema);
    }
}
