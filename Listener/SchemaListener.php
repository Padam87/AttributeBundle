<?php

namespace Padam87\AttributeBundle\Listener;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Entity\SchemaAwareInterface;
use \Doctrine\ORM\Proxy\Proxy;

/**
 * @DI\DoctrineListener(
 *     events = {"onFlush"},
 *     connection = "default"
 * )
 */
class SchemaListener
{
    protected $_em;

    protected $schemaRepo;

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $this->_em = $eventArgs->getEntityManager();
        $this->_uow = $this->_em->getUnitOfWork();

        foreach ($this->_uow->getScheduledEntityInsertions() AS $entity) {
            if ($entity instanceof Schema) {
                $this->orderSchema($entity);
            }
        }

        foreach ($this->_uow->getScheduledEntityUpdates() AS $entity) {
            if ($entity instanceof Schema) {
                $this->orderSchema($entity);
            }
        }
    }
    
    protected function orderSchema($schema)
    {
        $grouped = array(
            0 => array()
        );
        
        foreach ($schema->getAttributes() as $attribute) {
            $group = $attribute->getGroup() === NULL ? 0 : $attribute->getGroup()->getId();
            
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
                $this->_uow->computeChangeSet($this->_em->getClassMetadata(get_class($attribute)), $attribute);
        
                $i++;
            }
        }
        
        $this->_em->persist($schema);
        $this->_uow->computeChangeSet($this->_em->getClassMetadata(get_class($schema)), $schema);
    }
}
