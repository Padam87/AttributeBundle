# Module Bundle #

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
		new Netpositive\DiscriminatorMapBundle\NetpositiveDiscriminatorMapBundle(),
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
	
	netpositive_discriminator_map:
	    discriminator_map:
	        attribute:
	            entity: Padam87\AttributeBundle\Entity\Attribute
	            children:

padam87_attribute.schema.class maps the classes which you assign attributes to.

## 2. Usage

### 2.1 Create your Attribute entity

	<?php
	
	namespace Padam87\BaseBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Padam87\AttributeBundle\Entity\Attribute as BaseAttribute;
	
	/**
	 * @ORM\Entity()
	 */
	class Attribute extends BaseAttribute
	{
	    /**
	     * @ORM\ManyToOne(targetEntity="Product", inversedBy="attributes")
	     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	     * @var Schema
	     */
	    private $product;
	
	    /**
	     * Set product
	     *
	     * @param \Padam87\BaseBundle\Entity\Product $product
	     * @return Attribute
	     */
	    public function setProduct(\Padam87\BaseBundle\Entity\Product $product = null)
	    {
	        $this->product = $product;
	    
	        return $this;
	    }
	
	    /**
	     * Get product
	     *
	     * @return \Padam87\BaseBundle\Entity\Product 
	     */
	    public function getProduct()
	    {
	        return $this->product;
	    }
	}

### 2.2 Modify the entity which you want to assign attributes to

	<?php
	
	namespace Padam87\BaseBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;

	/**
	 * @ORM\Entity()
	 * @ORM\Table(name="product")
	 * @ORM\HasLifecycleCallbacks()
	 */
	class Product
	{
	   ...
	    
	    /**
	     * @ORM\OneToMany(targetEntity="Attribute", mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
	     */
	    protected $attributes;

		..
	}

### 2.3 Add the changes to the config.yml

	padam87_attribute:
	    schema:
	        class:
	            product: Padam87\BaseBundle\Entity\Product
	
	netpositive_discriminator_map:
	    discriminator_map:
	        attribute:
	            entity: Padam87\AttributeBundle\Entity\Attribute
	            children:
	                productAttribute: Padam87\BaseBundle\Entity\Attribute

### 2.4 Apply the schema

Every new entity needs to have the attributes, so we have to clone them from the schema.

    protected function newProduct()
    {
        $Product = new Product();
        
        $Schema = $this->_em->getRepository('Padam87AttributeBundle:Schema')->findOneBy(array(
            'class' => get_class($Product)
        ));
        
        $Schema->applyTo($Product, 'Padam87\BaseBundle\Entity\Attribute');
        
        return $Product;
    }

### 2.5 Add attributes to your form

	$builder->add('attributes', 'collection', array(
		'type'          => new AttributeType(),
		'allow_add'     => false,
		'allow_delete'  => false,
		'prototype'     => false,
		'by_reference'  => false,
		'options'       => array(
		),
	));

### 2.6 Add attributes to your view

	{% for attribute in form.attributes %}
        {{ form_widget(attribute) }}
    {% endfor %}

Each Attribute's form widget will be rendered as the definition specifies.

### 2.7 Create your Definitions and Schemas

/admin/attribute-definition and /admin/attribute-schema

### 2.8  View for Definitions and Schemas

Athough the bundle provides a default view, you would propably want to create your own.
You can do that by adding a folder, ad copying the bundles views here:

	app/Resources/Padam87AttributeBundle

OR

You can create yout own bundle as a child of this one.

## 3. Depenedncies

[NetpositiveDiscriminatorMapBundle](https://github.com/Netpositive/NetpositiveDiscriminatorMapBundle)

[Padam87SearchBundle](https://github.com/Padam87/SearchBundle)

[KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle)
