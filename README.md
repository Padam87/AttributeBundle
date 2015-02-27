[![Build Status](https://travis-ci.org/Padam87/AttributeBundle.png?branch=master)](https://travis-ci.org/Padam87/AttributeBundle)
[![Coverage Status](https://coveralls.io/repos/Padam87/AttributeBundle/badge.png)](https://coveralls.io/r/Padam87/AttributeBundle)


# Padam87AttributeBundle

An [EAV](http://en.wikipedia.org/wiki/Entity%E2%80%93attribute%E2%80%93value_model) implementation for Symfony2.

The purpose of this bundle is to allow users to create custom fields for entities.

## Supported uses cases

At the moment, there are two supported use cases :

1. Custom fields are the same across all instances of a given entity : there is
a schema that is shared between theses instances.
2. Custom fields vary from one instance to another.

There is a third use case that is not officially supported nor documented yet is
possible : having the schema defined as part of one entity, and used by relations
of this entity.

## Installation

To install the bundle, follow [this guide][0].

## Usage

### With a shared Schema

Custom fields are related to the entity. When the schema is updated, the attributes are synchronized.
More details in [this guide][1].

### Without any shared schema

Custom fields are related to each entity instance individually.
More details in [this guide][2].


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/Padam87/attributebundle/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

[0]: https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/installation.md
[1]: https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/usage_with_schema.md
[2]: https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/usage_without_schema.md
