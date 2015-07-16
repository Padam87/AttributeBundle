<?php

namespace Padam87\AttributeBundle\Tests\EventListener;

use Doctrine\DBAL\Logging\DebugStack;
use \Mockery as m;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Padam87\AttributeBundle\Entity\Definition;
use Padam87\AttributeBundle\Entity\Schema;
use Padam87\AttributeBundle\Tests\Model\Subscriber;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttributeCreatorListenerTest extends WebTestCase
{
    protected function setUp()
    {
        static::bootKernel();
    }

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

        /** @var DebugStack $profiler */
        $profiler = $container->get('doctrine.dbal.logger.profiling.default');

        $subscriber = new Subscriber();

        // FIRST PASS
        for ($i = 0; $i < 5; $i++) {
            $definition = new Definition();
            $definition->setName($i);
            $definition->setType('text');

            $schema->addDefinition($definition);
        }

        $em->persist($schema);
        $em->flush($schema);
        $em->refresh($schema);

        $this->assertCount(5, $schema->getDefinitions());

        $em->persist($subscriber);
        $em->flush($subscriber);

        $profiler->queries = []; // reset the profiler to show oly relevant queries

        $em->refresh($subscriber);
        
        $this->assertCount(5, $subscriber->getAttributes());
        $this->assertCount(16, $profiler->queries);

        // SECOND PASS
        for ($i = 5; $i < 10; $i++) {
            $definition = new Definition();
            $definition->setName($i);
            $definition->setType('text');

            $schema->addDefinition($definition);
        }

        $em->persist($schema);
        $em->flush($schema);
        $em->refresh($schema);

        $this->assertCount(10, $schema->getDefinitions());

        $subscriber->setName('test');
        $em->flush($subscriber);

        $profiler->queries = []; // reset the profiler to show oly relevant queries

        $em->refresh($subscriber);

        $this->assertCount(10, $subscriber->getAttributes());
        $this->assertCount(16, $profiler->queries);
    }
}
