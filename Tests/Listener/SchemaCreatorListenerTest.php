<?php

namespace Padam87\AttributeBundle\Tests\Listener;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\SchemaTool;
use \Mockery as m;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SchemaCreatorListenerTest extends KernelTestCase
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
    public function entityShouldHaveSchema()
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

        $class = 'Padam87\AttributeBundle\Tests\Model\Subscriber';

        $evm = $em->getEventManager();
        $eventArgs = new LoadClassMetadataEventArgs($em->getClassMetadata($class), $em);
        $evm->dispatchEvent(Events::loadClassMetadata, $eventArgs);

        $schema = $em->getRepository('Padam87AttributeBundle:Schema')->findOneBy([
            'className' => $class
        ]);

        $this->assertInstanceOf('Padam87\AttributeBundle\Entity\Schema', $schema);
    }
}
