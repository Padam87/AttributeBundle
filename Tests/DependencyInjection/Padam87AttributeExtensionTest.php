<?php
namespace Padam87\AttributeBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Padam87\AttributeBundle\DependencyInjection\Padam87AttributeExtension;

class Padam87AttributeExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(
            new Padam87AttributeExtension()
        );
    }

    public function testLoad()
    {
        $this->load();

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'attribute.attribute_creator',
            'doctrine.event_listener',
            array('event' => 'postLoad')
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'attribute.schema_creator',
            'doctrine.event_listener',
            array('event' => 'loadClassMetadata')
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'form.type.attributeCollection',
            'form.type',
            array('alias' => 'attributeCollection')
        );
    }
}
