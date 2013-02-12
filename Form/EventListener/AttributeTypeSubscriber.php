<?php
namespace Padam87\AttributeBundle\Form\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

class AttributeTypeSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
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

        if ($data->getDefinition() != null) {
            $params = array();

            $type = $data->getDefinition()->getType();
            $options = $data->getDefinition()->getOptions()->toArray();

            if ($type == 'choice' || $type == 'checkbox' || $type == 'radio') {

                if ($type == 'radio') {
                    $params['expanded'] = true;
                    $params['multiple'] = false;
                } elseif ($type == 'checkbox') {
                    $params['expanded'] = true;
                    $params['multiple'] = true;
                }

                $params['choices'] = array();

                foreach ($options as $option) {
                    $params['choices'][$option->getName()] = $option->getName();
                }
                
                $type = 'choice';
            }

            if ($data->getRequired() == true) {
                $params['required'] = true;
            } else {
                $params['required'] = false;
            }

            $params['label'] = $data->getDefinition()->getName();

            if($type == 'text') $params['attr']['addon'] = $data->getUnit();

            $form->add($this->factory->createNamed('value', $type, $data->getValue(), $params));
        }
    }
}
