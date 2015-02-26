#Installation

##1, Composer

	composer require padam87/attribute-bundle

##2, AppKernel

This bundle uses `jms/di-extra-bundle`. Make sure you register it in the kernel.

	$bundles = array(
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\AopBundle\JMSAopBundle(),
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

`jms_di_extra` configuration is unnecessary if you have set `all_bundles` to `true`
