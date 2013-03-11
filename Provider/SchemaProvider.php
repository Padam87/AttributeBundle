<?php

namespace Padam87\AttributeBundle\Provider;

use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\ORM\EntityManager;

/**
 * @DI\Service("attribute.schema")
 */
class SchemaProvider
{
    private $_em;

    private $schemaRepo;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
        $this->schemaRepo = $em->getRepository('Padam87AttributeBundle:Schema');
    }

    /**
     * Finds the schema for the given entity
     *
     * @return Schema
     */
    public function get($entity)
    {
        return $this->schemaRepo->findOneBy(array(
            'className' => get_class($entity)
        ));
    }

    /**
     * Applies the matching schema to an entity
     *
     * @return entity
     */
    public function applyTo($entity, $schema = null)
    {
        if ($schema == null) {
            $schema = $this->get($entity);
        }

        if ($schema != null) {
            $metadata = $this->_em->getClassMetadata($schema->getClassName());
            $attributeMapping = $metadata->getAssociationMapping('attributeValues');

            foreach ($schema->getAttributes() as $attribute) {
                $exists = false;

                foreach ($entity->getAttributeValues() as $value) {
                    if ($value->getAttribute()->getId() == $attribute->getId()) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $value = new $attributeMapping['targetEntity'];
                    $value->setAttribute($attribute);

                    $entity->addAttributeValue($value);
                }
            }
        }

        $values = $entity->getAttributeValues();
        $count = $values->count() - 1;

        for ($i = 1; $i <= $count - 1; $i++) {
            for ($j = $i + 1; $j <= $count; $j++) {
                $iIndex = $values->get($i)->getAttribute()->getOrderIndex();
                $jIndex = $values->get($j)->getAttribute()->getOrderIndex();

                if ($iIndex > $jIndex) {
                    $iValue = $values->get($i);

                    $values->set($i, $values->get($j));
                    $values->set($j, $iValue);
                }
            }
        }

        if ($this->_em->getUnitOfWork()->getEntityState($entity) == \Doctrine\ORM\UnitOfWork::STATE_MANAGED) {
            $this->_em->persist($entity);
            $this->_em->flush($entity);
        }

        return $entity;
    }
}