<?php

namespace Padam87\AttributeBundle\CacheWarmer;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class EntityAnnotationCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param ManagerRegistry $doctrine
     * @param                 $debug
     */
    public function __construct(ManagerRegistry $doctrine, $debug)
    {
        $this->doctrine = $doctrine;
        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        $filename = $cacheDir . '/padam87/attribute_bundle/Entity.cache.php';

        $cache = new ConfigCache($filename, $this->debug);

        if (!$cache->isFresh()) {
            $content  = '<?php return ' . var_export($this->getEntities(), true) . ';';
            $cache->write($content, $this->getResources());
        }
    }

    protected function getEntities()
    {
        $entities = [];

        $reader = new AnnotationReader();

        /** @var ClassMetadata $metadata */
        foreach ($this->getMetadata() as $metadata) {
            $refl = $metadata->getReflectionClass();

            if ($refl === null) {
                $refl = new \ReflectionClass($metadata->getName());
            }

            if ($reader->getClassAnnotation($refl, 'Padam87\AttributeBundle\Annotation\Entity') != null) {
                $entities[$metadata->getName()] = true;
            }
        }

        return $entities;
    }

    /**
     * @return array
     */
    protected function getResources()
    {
        $res = [];

        /** @var ClassMetadata $m */
        foreach ($this->getMetadata() as $m) {
            $res[] = new FileResource($m->getReflectionClass()->getFileName());
        }

        return $res;
    }

    /**
     * @return array
     */
    protected function getMetadata()
    {
        $em = $this->doctrine->getManager();

        return $em->getMetadataFactory()->getAllMetadata();
    }
}
