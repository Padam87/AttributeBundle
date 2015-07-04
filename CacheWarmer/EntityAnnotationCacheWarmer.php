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
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
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
        $dirname = $cacheDir . '/padam87/attribute_bundle';

        if (!is_dir($dirname)) {
            @mkdir($dirname, 0666, true);
        }

        $filename = $dirname . DIRECTORY_SEPARATOR . 'Entity.cache.php';
        $cache = new ConfigCache($filename, true);

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
