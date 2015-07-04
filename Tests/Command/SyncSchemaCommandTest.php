<?php

namespace Padam87\AttributeBundle\Tests\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Padam87\AttributeBundle\Command\SyncSchemaCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class SyncSchemaCommandTest extends KernelTestCase
{
    protected function setUp()
    {
        static::bootKernel();

        $container = static::$kernel->getContainer();
        /** @var ManagerRegistry $doctrine */
        $doctrine = $container->get('doctrine');
        /** @var EntityManager $em */
        $em = $doctrine->getManager();
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    /**
     * @test
     * @group functional
     */
    public function execute()
    {
        $application = new Application(static::$kernel);
        $application->add(new SyncSchemaCommand());

        $command = $application->find('eav:schema:sync');
        $commandTester = new CommandTester($command);

        // FIRST PASS
        $commandTester->execute(['command' => $command->getName()]);

        $output = <<<OUTPUT
+-----------+------------------------------------------------+
| Created:  | Padam87\AttributeBundle\Tests\Model\Subscriber |
+-----------+------------------------------------------------+
| Existing: |                                                |
+-----------+------------------------------------------------+

OUTPUT;
        $this->assertSame(str_replace(PHP_EOL, "\n", $output), $commandTester->getDisplay(true));

        // SECOND PASS
        $commandTester->execute(['command' => $command->getName()]);

        $output = <<<OUTPUT
+-----------+------------------------------------------------+
| Created:  |                                                |
+-----------+------------------------------------------------+
| Existing: | Padam87\AttributeBundle\Tests\Model\Subscriber |
+-----------+------------------------------------------------+

OUTPUT;
        $this->assertSame(str_replace(PHP_EOL, "\n", $output), $commandTester->getDisplay(true));
    }
}
