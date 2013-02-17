<?php
namespace Padam87\AttributeBundle\Form\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

class AttributeTypeSubscriber implements EventSubscriberInterface
{
    private $factory;
    private $options;

    private $defaultOptions = array(
        'allow_expanded' => true,
        'all_multiple' => false
    );

    public function __construct(FormFactoryInterface $factory, $options = array())
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
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data || !$form->has('value')) {
            return;
        }

        if ($data->getAttribute()->getDefinition() != null) {
            $attribute = $data->getAttribute();
            $group = $attribute->getGroup() ;
            $definition = $attribute->getDefinition();

            $type = $definition->getType();
            $options = $definition->getOptions()->toArray();

            $params = array(
                'attr' => array(

                )
            );

            if ($type == 'choice' || $type == 'checkbox' || $type == 'radio') {
                if (($type == 'checkbox' || $type == 'radio') && $this->getOption('allow_expanded') == true) {
                    $params['expanded'] = true;
                }

                if ($this->getOption('all_multiple')) {
                    $params['multiple'] = true;
                } else {
                    if ($type == 'radio') {
                        $params['multiple'] = false;
                    } elseif ($type == 'checkbox') {
                        $params['multiple'] = true;
                    }
                }

                $params['choices'] = array();

                foreach ($options as $option) {
                    $params['choices'][$option->getName()] = $option->getName();
                }

                $type = 'choice';
            }

            if ($attribute->getRequired() == true) {
                $params['required'] = true;
            } else {
                $params['required'] = false;
            }

            $params['label'] = $definition->getName();

            if ($group != NULL) {
                $params['attr']['group'] = $group->getName();
            }

            if ($attribute->getUnit() != "") {
                $params['attr']['unit'] = $attribute->getUnit();
            }

            $form->add($this->factory->createNamed('value', $type, $data->getValue(), $params));
        }
    }
}
