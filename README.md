[![Build Status](https://travis-ci.org/Padam87/AttributeBundle.png?branch=master)](https://travis-ci.org/Padam87/AttributeBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Padam87/AttributeBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Padam87/AttributeBundle/?branch=master)
[![Coverage Status](https://coveralls.io/repos/Padam87/AttributeBundle/badge.png)](https://coveralls.io/r/Padam87/AttributeBundle)

[![License](https://poser.pugx.org/padam87/attribute-bundle/license)](https://packagist.org/packages/padam87/attribute-bundle)
[![Latest Stable Version](https://poser.pugx.org/padam87/attribute-bundle/v/stable)](https://packagist.org/packages/padam87/attribute-bundle)
[![Latest Unstable Version](https://poser.pugx.org/padam87/attribute-bundle/v/unstable)](https://packagist.org/packages/padam87/attribute-bundle)
[![Total Downloads](https://poser.pugx.org/padam87/attribute-bundle/downloads)](https://packagist.org/packages/padam87/attribute-bundle)
[![Monthly Downloads](https://poser.pugx.org/padam87/attribute-bundle/d/monthly)](https://packagist.org/packages/padam87/attribute-bundle)

## DEPRECATED
Please don't use this bundle in a production environment. Years ago, when I created this bundle EAV was a good choice to store data which had a loose schema in SQL. Nowdays we have all kinds of schema less storage options which are better suited for this job.

If you absolutely have to use SQL, EAV can still help you, and this bundle should be able to inspire you.

# Padam87AttributeBundle

An [EAV](http://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model) implementation for Symfony2.

The purpose of this bundle is to allow users to create custom fields for entities.

Custom fields can be unique per row in the DB, or can be related to an entity itself.

[Installation](https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/installation.md)

[Usage with Schema](https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/usage_with_schema.md):
Custom fields are related to the entity. When the schema is updated, the attributes are synchronized.

[Usage without Schema](https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/usage_without_schema.md):
Custom fields are related to each data row individually.

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/Padam87/attributebundle/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

