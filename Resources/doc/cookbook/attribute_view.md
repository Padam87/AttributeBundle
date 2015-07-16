```html+jinja
{% for attribute in object.attributes %}
    {% if attribute.definition.options is not empty %}
        {% for option in attribute.definition.options %}
        {% if attribute.value == option.value %}
            {{ option.name }}
        {% endif %}
        {% endfor %}
    {% else %}
        {{ attribute.value }}
    {% endif %}
{% endfor %}
```
