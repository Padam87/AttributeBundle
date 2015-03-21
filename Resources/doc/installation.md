#Installation

##1, Composer

	composer require padam87/attribute-bundle

##2, AppKernel

	$bundles = array(
	    ...
	    new Padam87\AttributeBundle\Padam87AttributeBundle(),
	);

##3, config.yml

	imports:
	    ...
	    - { resource: "@Padam87AttributeBundle/Resources/config/config.yml" }
