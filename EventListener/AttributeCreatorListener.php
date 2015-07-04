<?php

namespace Padam87\AttributeBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\UnitOfWork;
use Padam87\AttributeBundle\Entity\Attribute;
use Doctrine\DBAL\DBALException;

class AttributeCreatorListener
{
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $eventArgs->getEntity();
        $refl = new \ReflectionClass($entity);

        $reader = new AnnotationReader();

        if ($reader->getClassAnnotation($refl, 'Padam87\AttributeBundle\Annotation\Entity') != null) {
            try {
                $schema = $em->getRepository('Padam87AttributeBundle:Schema')->findOneBy(array(
                    'className' => $refl->getName()
                ));

                if ($schema !== null) {
                    foreach ($schema->getDefinitions() as $definition) {
                        $qb = $em->getRepository($refl->getName())->createQueryBuilder('main');

                        $qb->join('main.attributes', 'a', 'WITH', 'a.definition = :definition');
                        $qb->where('main = :main');
                        $qb->setParameter('definition', $definition);
                        $qb->setParameter('main', $entity);

                        $attribute = $qb->getQuery()->getOneOrNullResult();

                        if ($attribute === null) {
                            $attribute = new Attribute();
                            $attribute->setDefinition($definition);

                            $entity->addAttribute($attribute);

                            if ($uow->getEntityState($entity) == UnitOfWork::STATE_MANAGED) {
                                $em->persist($entity);
                                $em->flush($entity);
                            }
                        }
                    }
                }
            } catch (DBALException $e) {
                // Discard DBAL exceptions in order for schema:update to work
            }
        }
    }
}
