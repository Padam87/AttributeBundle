<?php

namespace Padam87\AttributeBundle\Listener;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Entity\SchemaAwareInterface;
use \Doctrine\ORM\Proxy\Proxy;

/**
 * @DI\DoctrineListener(
 *     events = {"postPersist", "postUpdate"},
 *     connection = "default"
 * )
 */
class SchemaListener
{
    protected $_em;

    protected $schemaRepo;

    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $this->_em = $eventArgs->getEntityManager();

        if ($entity instanceof Schema) {
            $this->orderSchema($entity);
        }
    }

    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $this->_em = $eventArgs->getEntityManager();

        if ($entity instanceof Schema) {
            $this->orderSchema($entity);
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
                $this->_em->flush($attribute);
        
                $i++;
            }
        }
        
        $this->_em->persist($schema);
        $this->_em->flush($schema);
    }
}
