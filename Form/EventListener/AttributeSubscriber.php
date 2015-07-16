<?php
namespace Padam87\AttributeBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

class AttributeSubscriber implements EventSubscriberInterface
{
    private $factory;
    private $options;

    private $defaultOptions = [
        'allow_expanded' => true,
        'allow_textarea' => true,
        'all_multiple' => false,
    ];

    public function __construct(FormFactoryInterface $factory, $options = [])
    {
        $this->factory = $factory;
        $this->options = $options;
    }

    public function getOption($name)
    {
        if (!isset($this->options[$name])) {
            $value = $this->defaultOptions[$name];
        } else {
            $value = $this->options[$name];
        }

        return $value;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that we want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $this->createValueField($data, $form);
    }

    public function createValueField($data, $form, $fieldName = 'value')
    {
        if ($data->getDefinition() == null) {
            return false;
        }

        $attribute = $data;
        $definition = $attribute->getDefinition();

        $type = $definition->getType();
        $options = $definition->getOptions()->toArray();
        $value = $data->getValue();

        $params = [
            'attr' => $form->getConfig()->getOptions()['attr'],
        ];

        if ($type == 'textarea' && !$this->getOption('allow_expanded')) {
            $type = 'text';
        }

        if ($type == 'choice' || $type == 'checkbox' || $type == 'radio') {
            if (($type == 'checkbox' || $type == 'radio') && $this->getOption('allow_expanded')) {
                $params['expanded'] = true;
            }

            if ($this->getOption('all_multiple')) {
                $params['multiple'] = true;
            } else {
                if ($type == 'radio') {
                    $params['multiple'] = false;
                } elseif ($type == 'checkbox') {
                    if (!is_array($value)) {
                        $value = [
                            $value => $value,
                        ];
                    }

                    $params['multiple'] = true;
                }
            }

            $params['choices'] = [];

            foreach ($options as $option) {
                $params['choices'][$option->getValue()] = $option->getName();
            }

            $type = 'choice';
        } elseif (is_array($value)) {
            $value = null;
        }

        $params['required'] = $definition->getRequired();

        $params['label'] = $definition->getName();

        if ($definition->getUnit() != "") {
            $params['label_attr']['unit'] = $definition->getUnit();
        }

        if ($definition->getDescription() != "") {
            $params['label_attr']['help'] = $definition->getDescription();
        }

        $params['auto_initialize'] = false;

        $form->add($this->factory->createNamed($fieldName, $type, $value, $params));
    }
}
