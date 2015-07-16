#Usage with Schema

Custom fields are related to the entity. When the schema is updated, the attributes are synchronized.

##1, Prepare your entity


```php
use Padam87\AttributeBundle\Annotation as EAV;
use Padam87\AttributeBundle\Entity\AttributedEntityTrait;

// ...

/**
 * @EAV\Entity()
 * ...
 */
class Entity
{
    use AttributedEntityTrait;

    //...
}
```

If you are not using PHP >=5.4, copy the contents of the trait to your class.
If you are not using annotations, you should map the relationship to the
attributes yourself. For instance, in yaml :

```yml
manyToMany:
    attributes:
        targetEntity: Padam87\AttributeBundle\Entity\Attribute
        fetch: EAGER
        cascade: [persist, remove]
```

##2, Update your form

You can use the `Padam87\AttributeBundle\Form\AttributeType` type in the form
where you want to define new values for a schema that is already defined :

```php
use Padam87\AttributeBundle\Form\AttributeType;

// ...

public function buildForm(FormBuilderInterface $builder, array $options)
{
    // ...

    $builder->add('attributes', 'attributeCollection', array(
        'type' => new AttributeType()
    ));

    // ...
}
```

##3, Make sure the view shows the new attributes field

`{{ form_widget(form.attributes) }}`

##4, Update your database

Run `doctrine:schema:update` or create a migration to change the sql schema

Run `eav:schema:sync` to update the database to the current schema settings

##5, Managing Schemas and Definitions

This bundle does not provide a Controller / View implementation,
although Sonata admin classes are likely to be added later.

##6, Done

The rest should work like magic. A listener will synchronize all changes in the schema when an entity is loaded.

Check the [Cookbook](https://github.com/Padam87/AttributeBundle/blob/master/Resources/doc/cookbook/cookbook.md) for some common use-case examples.
