<?php

namespace Padam87\AttributeBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\UnitOfWork;
use Padam87\AttributeBundle\Entity\Attribute;
use Padam87\AttributeBundle\Entity\Schema;

class AttributeCreatorListener
{
    private $entities = null;

    private $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $eventArgs->getEntity();
        $classname = get_class($entity);

        if (!array_key_exists($classname, $this->getEntities())) {
            return null;
        }

        /** @var Schema $schema */
        $schema = $em->getRepository('Padam87AttributeBundle:Schema')->findOneBy([
            'className' => $classname,
        ]);

        if ($schema === null) {
            throw new \UnexpectedValueException('Schema not found for ' . $classname);
        }

        $qb = $em->getRepository($classname)->createQueryBuilder('main');

        $qb
            ->distinct()
            ->select('d.id')
            ->join('main.attributes', 'a')
            ->join('a.definition', 'd', null, null, 'd.id')
            ->where('main = :main')
            ->setParameter('main', $entity)
        ;

        $definitions = $qb->getQuery()->getArrayResult();

        foreach ($schema->getDefinitions() as $definition) {
            if (!array_key_exists($definition->getId(), $definitions)) {
                $attribute = new Attribute();
                $attribute->setDefinition($definition);

                $entity->addAttribute($attribute);
            }
        }

        if ($uow->getEntityState($entity) == UnitOfWork::STATE_MANAGED) {
            $em->persist($entity);
            $em->flush($entity);
        }
    }

    /**
     * @return array
     */
    protected function getEntities()
    {
        if ($this->entities === null) {
            $this->entities = include $this->cacheDir . '/padam87/attribute_bundle/Entity.cache.php';
        }

        return $this->entities;
    }
}
