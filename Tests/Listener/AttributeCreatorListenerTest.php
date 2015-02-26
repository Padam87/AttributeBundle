<?php

namespace Padam87\AttributeBundle\Tests\Listener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use \Mockery as m;
use Padam87\AttributeBundle\Entity\Definition;
use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Tests\Model\Subscriber;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttributeCreatorListenerTest extends WebTestCase
{
    protected function tearDown()
    {
        static::ensureKernelShutdown();

        m::close();
    }

    /**
     * @test
     * @group functional
     */
    public function entityShouldHaveAttributes()
    {
        self::bootKernel();

        $container = self::$kernel->getContainer();
        /** @var Registry $doctrine */
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
