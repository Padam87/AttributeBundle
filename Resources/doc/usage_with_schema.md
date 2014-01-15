#Usage with Schema

Custom fields are related to the entity. When the schema is updated, the attributes are syncronized.

##1, Prepare your entity

    ...

	use Padam87\AttributeBundle\Annotation as EAV;
    use Padam87\AttributeBundle\Entity\AttributedEntityTrait;

    ...

    /**
     * @EAV\Entity()
     * ...
     */
    class Entity
    {
        use AttributedEntityTrait;

        ...
    }

If you are not using PHP >=5.4, copy the contents of the trait to your class

##2, Update your form

	...

    use Padam87\AttributeBundle\Form\AttributeType;

    ...

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        ...

        $builder->add('attributes', 'attributeCollection', array(
            'type' => new AttributeType()
        ));

        ...
    }

##3, Make sure the view shows the new attributes field

    {{ form_widget(form.attributes) }}

##4, Update your database

    doctrine:schema:update

##5, Editing a schema

###5.1, General information

URL:

    /attribute/schema/edit/{id}

Route:

    padam87_attribute_schema_edit

You can fetch the schema like by the class name of your entity:

    $schema = $em->getRepository('Padam87AttributeBundle:Schema')->findOneBy(array(
        'className' => get_class($entity)
    ));

###5.2, Creating the view

The bundle does not provide a View for schema editing, only a Controller, because of the wide range of possible customizations.

Create the `edit.html.twig` file under `app/Resources/Padam87AttributeBundle/views/Schema`

Here is very simple working example, just for some pointers:

    {% extends "::base.html.twig" %}

    {% block body %}{# or whatever is your block name #}
    <form method="POST" action="{{ path('padam87_attribute_schema_edit', { id: schema.getId() }) }}">
        {{ form_rest(form) }}

        <div class="form-actions">
            <button class="btn btn-primary" role="submit">{% trans %}Save{% endtrans %}</button>
            <a class="btn btn-success" href="#" onclick="Schema.addDefinition(); return false;">
                {% trans %}Add new item{% endtrans %}
            </a>
        </div>

        <script>
            Schema = {
                addDefinition: function() {
                    var prototype = $('#schema_definitions').data('prototype');
                    var newItem = prototype.replace(/_name/g, $('#schema_definitions').children().length);

                    $('#schema_definitions').append(newItem);
                }
            }
        </script>
    </form>
    {% endblock %}

##6, Done

The rest should work like magic.

- A schema is created for each entity with the `@EAV\Entity()` annotation.
- A listener will syncronise all changes in the schema when an entity is loaded.
