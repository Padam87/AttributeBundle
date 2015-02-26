<?php

namespace Padam87\AttributeBundle\Tests\Traits;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $this->assertEquals(1, count($output));
        $this->assertEquals("Clearing the cache for the prod environment with debug false", $output[0]);
    }
}
