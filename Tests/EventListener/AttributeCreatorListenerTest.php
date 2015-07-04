<?php

namespace Padam87\AttributeBundle\Tests\EventListener;

use \Mockery as m;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Padam87\AttributeBundle\Entity\Definition;
use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Tests\Model\Subscriber;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AttributeCreatorListenerTest extends KernelTestCase
{
    protected function tearDown()
    {
        m::close();

        parent::tearDown();
    }

    /**
     * @test
     * @group functional
     */
    public function entityShouldHaveAttributes()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $container = static::$kernel->getContainer();
        /** @var ManagerRegistry $doctrine */
        $doctrine = $container->get('doctrine');
        /** @var EntityManager $em */
        $em = $doctrine->getManager();
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        $schema = new Schema();
        $schema->setClassName('Padam87\AttributeBundle\Tests\Model\Subscriber');

        for ($i = 0; $i < 5; $i++) {
            $definition = new Definition();
            $definition->setName($i);
            $definition->setType('text');

            $schema->addDefinition($definition);
        }

        $em->persist($schema);
        $em->flush($schema);
        $em->clear();

        $subscriber = new Subscriber();
        $em->persist($subscriber);
        $em->flush($subscriber);
        $em->refresh($subscriber);

        $this->assertCount(5, $subscriber->getAttributes());
    }
}
