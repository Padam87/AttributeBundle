<?php

namespace Padam87\AttributeBundle\Tests\Entity;

use \Mockery as m;
use Padam87\AttributeBundle\Entity\Attribute;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     */
    public function setValueScalar()
    {
        $attribute = new Attribute();
        $attribute->setValue(1);

        $refl = new \ReflectionProperty($attribute, 'value');
        $refl->setAccessible(true);

        $this->assertEquals(1, $refl->getValue($attribute));
    }

    /**
     * @test
     */
    public function setValueArray()
    {
        $attribute = new Attribute();
        $attribute->setValue([1]);

        $refl = new \ReflectionProperty($attribute, 'value');
        $refl->setAccessible(true);

        $this->assertEquals('a:1:{i:0;i:1;}', $refl->getValue($attribute));
    }

    /**
     * @test
     */
    public function getValueScalar()
    {
        $attribute = new Attribute();
        $attribute->setValue(1);

        $this->assertEquals(1, $attribute->getValue());
    }

    /**
     * @test
     */
    public function getValueArray()
    {
        $attribute = new Attribute();
        $attribute->setValue([1]);

        $this->assertEquals([1], $attribute->getValue());
    }
}
