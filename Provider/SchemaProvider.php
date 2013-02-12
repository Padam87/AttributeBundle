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
     * Applies the matching schema to an entity
     *
     * @return entity
     */
    public function applyTo($entity)
    {
        $schema = $this->schemaRepo->findOneBy(array(
            'className' => get_class($entity)
        ));

        if ($schema != null) {
            $metadata = $this->_em->getClassMetadata($schema->getClassName());

            $attributeMapping = $metadata->getAssociationMapping('attributes');

            $schema->applyTo($entity, $attributeMapping['targetEntity']);
        }

        return $entity;
    }
}
