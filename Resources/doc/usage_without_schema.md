#Usage without Schema

Custom fields are related to each data row individually.

##1, Prepare your entity

    ...

    use Padam87\AttributeBundle\Entity\AttributedEntityTrait;

    ...

    class Entity
    {
        use AttributedEntityTrait;

        ...
    }

If you are not using PHP >=5.4, copy the contents of the trait to your class

##2, Update your form

	...

    use Padam87\AttributeBundle\Form\CompleteAttributeType;

    ...

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        ...

        $builder->add('attributes', 'collection', array(
            'type' => new CompleteAttributeType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ));

        ...
    }

##3, Make sure the view shows the new attributes field

    {{ form_widget(form.attributes) }}

##4, Update your database

    doctrine:schema:update

##5, Implement the prototype on the frontend

[Read about it in the Cookbook](http://symfony.com/doc/current/cookbook/form/form_collections.html#cookbook-form-collections-new-prototype)

##6, Done

The rest should work like magic.

- All entities are cascaded on persist and remove.
