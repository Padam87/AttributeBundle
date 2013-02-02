# Attribute Bundle #

An [EAV](http://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model) implementation for Symfony2.

## 1. Installation

### 1.1 Composer

    "padam87/attribute-bundle": "dev-master",

### 1.2 AppKernel:

    $bundles = array(
		...
		new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Padam87\SearchBundle\Padam87SearchBundle(),
        new Padam87\AttributeBundle\Padam87AttributeBundle(),
    );        

### 1.3 Routing:

	Padam87AttributeBundle:
	    resource: "@Padam87AttributeBundle/Controller/"
	    type:     annotation
	    prefix:   /admin

The route will be /admin/attribute-definition and /admin/attribute-schema this way... feel free to modify.

### 1.4 config.yml

Insert this to your config.yml.
    
	padam87_attribute:
	    schema:
	        class:
				niceNameForYourClass: Vendor\Bundle\Entity\EntityName

	jms_di_extra:
	    locations:
	        all_bundles: false
	        bundles: [Padam87AttributeBundle]

padam87_attribute.schema.class maps the classes which you can assign a schema (set of attributes) to.

jms_di_extra configuration is unnecessary if you have set all_bundles to true

## 2. Usage

### 2.1 Create your Attribute entity

	<?php
	
	namespace Padam87\BaseBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Padam87\AttributeBundle\Entity\Attribute as AbstractAttribute;
	
	/**
	 * @ORM\Entity()
 	 * @ORM\Table(name="product_attribute")
	 */
	class Attribute extends AbstractAttribute
	{
	    /**
	     * @ORM\ManyToOne(targetEntity="Product", inversedBy="attributes")
	     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	     * @var Schema
	     */
	    private $product;

		...
	}

### 2.2 Modify the entity which you want to assign attributes to

	<?php
	
	namespace Padam87\BaseBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;
	use Padam87\AttributeBundle\Entity\SchemaAwareInterface;

	/**
	 * @ORM\Entity()
	 * @ORM\Table(name="product")
	 * @ORM\HasLifecycleCallbacks()
	 */
	class Product implements SchemaAwareInterface
	{
	   ...
	    
	    /**
	     * @ORM\OneToMany(targetEntity="Attribute", mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
	     */
	    protected $attributes;

		...
	}

### 2.3 Apply the schema

Every new entity needs to have the attributes, so instead of just creating a new entity, use the following service:

    //$product = new Product();
    $product = $this->get('attribute.schema')->applyTo(new Product());

Note: Managed entities will update automatically, no worries there.

### 2.4 Add attributes to your form

	$builder->add('attributes', 'collection', array(
		'type'          => new AttributeType(),
		'allow_add'     => false,
		'allow_delete'  => false,
		'prototype'     => false,
		'by_reference'  => false,
		'options'       => array(
		),
	));

### 2.5 Add attributes to your view

	{% for attribute in form.attributes %}
        {{ form_widget(attribute) }}
    {% endfor %}

Each Attribute's form widget will be rendered as the definition specifies (text, select, etc).

### 2.6 Create your Definitions and Schemas

/admin/attribute-definition and /admin/attribute-schema

### 2.7  View for Definitions and Schemas (optional)

Athough the bundle provides a default view, you would propably want to create your own.
You can do that by adding a folder, and copying the bundles views here:

	app/Resources/Padam87AttributeBundle

OR

You can create yout own bundle as a child of this one.

## 3. Depenedncies

[Padam87SearchBundle](https://github.com/Padam87/SearchBundle)

[KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle)
