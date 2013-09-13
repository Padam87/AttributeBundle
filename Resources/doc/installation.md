#Installation

##1, Composer

	"padam87/attribute-bundle": "dev-master"

##2, AppKernel

	$bundles = array(
	    ...
	    new Padam87\AttributeBundle\Padam87AttributeBundle(),
	);

##3, config.yml

	imports:
	    ...
	    - { resource: "@Padam87AttributeBundle/Resources/config/config.yml" }

	...

	jms_di_extra:
	    locations:
	        all_bundles: false
	        bundles: [Padam87AttributeBundle]

jms_di_extra configuration is unnecessary if you have set all_bundles to true