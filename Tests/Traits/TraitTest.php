<?php

namespace Padam87\AttributeBundle\Tests\Traits;

use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class TraitTest extends WebTestCase
{
    public function setUp()
    {
        self::createClient();
    }

    public function testCacheClear()
    {
        exec(
            'php ' . self::$kernel->getRootDir() . '/console cache:clear --env="prod"',
            $output,
            $exitCode
        );

        $this->assertEquals(0, $exitCode);
    }

    public function testCacheClearNoOptionalWarmers()
    {
        exec(
            'php ' . self::$kernel->getRootDir() . '/console cache:clear --env="prod" --no-optional-warmers',
            $output,
            $exitCode
        );

        $this->assertEquals(0, $exitCode);
    }
}
