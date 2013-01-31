<?php

namespace Padam87\AttributeBundle\Listener;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Entity\SchemaAwareInterface;
use \Doctrine\ORM\Proxy\Proxy;

/**
 * @DI\DoctrineListener(
 *     events = {"postLoad"},
 *     connection = "default"
 * )
 */
class SchemaListener
{
    protected $_em;
    
    protected $schemaRepo;
    
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $this->_em = $eventArgs->getEntityManager();
        
        if ($this->schemaRepo == null) {
            $this->schemaRepo = $this->_em->getRepository('Padam87AttributeBundle:Schema');
        }
        
        $entity = $eventArgs->getEntity();
        
        if ($entity instanceof SchemaAwareInterface && !$entity instanceof Proxy) {
            $class = get_class($entity);
            $metadata = $this->_em->getClassMetadata($class);
            $attributeMapping = $metadata->getAssociationMapping('attributes');
            
            $refl = new \ReflectionClass($attributeMapping['targetEntity']);
            
            if ($refl->getParentClass()->getName() == 'Padam87\AttributeBundle\Entity\AbstractAttribute') {
                $schema = $this->schemaRepo->findOneBy(array(
                    'class' => $class
                ));
                
                $schema->applyTo($entity, $attributeMapping['targetEntity']);
                
                $this->_em->persist($entity);
                $this->_em->flush($entity);
            }
        }
    }
}
