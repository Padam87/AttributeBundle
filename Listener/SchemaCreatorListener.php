<?php

namespace Padam87\AttributeBundle\Listener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;
use Padam87\AttributeBundle\Entity\Schema;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\DBAL\DBALException;

/**
 * @DI\Service("attribute.schema_creator")
 * @DI\Tag("doctrine.event_listener", attributes = {"event" = "loadClassMetadata"})
 */
class SchemaCreatorListener
{
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();

        $metadata = $eventArgs->getClassMetadata();
        $refl = $metadata->getReflectionClass();

        if ($refl === null) {
            $refl = new \ReflectionClass($metadata->getName());
        }

        $reader = new AnnotationReader();

        if ($reader->getClassAnnotation($refl, 'Padam87\AttributeBundle\Annotation\Entity') != null) {
            try {
                $schema = $em->getRepository('Padam87AttributeBundle:Schema')->findOneBy(array(
                    'className' => $metadata->getName()
                ));

                if ($schema === null) {
                    $schema = new Schema();
                    $schema->setClassName($metadata->getName());

                    $em->persist($schema);
                    $em->flush($schema);
                }
            } catch (DBALException $e) {
                // Discard DBAL exceptions in order for schema:update to work
            }
        }
    }
}
