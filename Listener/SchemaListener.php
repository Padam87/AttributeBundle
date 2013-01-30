<?php

namespace Padam87\AttributeBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Padam87\AttributeBundle\Entity\Schema;

class SchemaListener
{
    protected $_em;
    protected $_uow;

    public function __construct()
    {
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $this->_em = $eventArgs->getEntityManager();
        $this->_uow = $this->_em->getUnitOfWork();

        foreach ($this->_uow->getScheduledEntityInsertions() AS $entity) {
            if ($entity instanceof Schema) {
                $this->updateEntitySchema($entity);
            }
        }

        foreach ($this->_uow->getScheduledEntityUpdates() AS $entity) {
            if ($entity instanceof Schema) {
                $this->updateEntitySchema($entity);
            }
        }
    }

    protected function updateEntitySchema($Schema)
    {
        $entities = $this->_em->getRepository($Schema->getClass())->findAll();

        $metadata = $this->_em->getClassMetadata($Schema->getClass());

        $attributeMapping = $metadata->getAssociationMapping('attributes');
        $groupMapping = $metadata->getAssociationMapping('groups');

        foreach ($entities as $entity) {
            $entity = $Schema->applyTo($entity, $attributeMapping['targetEntity'], $groupMapping['targetEntity']);

            foreach ($entity->getAttributes() as $entityAttribute) {
                $this->_em->persist($entityAttribute);
                $this->_uow->computeChangeSet($this->_em->getClassMetadata(get_class($entityAttribute)), $entityAttribute);
            }

            foreach ($entity->getGroups() as $entityGroup) {
                $this->_em->persist($entityGroup);
                $this->_uow->computeChangeSet($this->_em->getClassMetadata(get_class($entityGroup)), $entityGroup);

                foreach ($entityGroup->getAttributes() as $groupAttribute) {
                    $this->_em->persist($groupAttribute);
                    $this->_uow->computeChangeSet($this->_em->getClassMetadata(get_class($groupAttribute)), $groupAttribute);
                }
            }

            $this->_em->persist($entity);
            $this->_uow->computeChangeSet($this->_em->getClassMetadata(get_class($entity)), $entity);
        }
    }
}
