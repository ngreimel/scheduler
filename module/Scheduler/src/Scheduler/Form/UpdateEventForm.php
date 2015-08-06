<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class UpdateEventForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('update-event');

        // The form will hydrate an object of type Event
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the event fieldset and set it as the base fieldset
        $eventFieldset = new EventFieldset($objectManager);
        $eventFieldset->setUseAsBaseFieldset(true);
        $this->add($eventFieldset);

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Go',
                'id'    => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));

        $this->setAttribute('role', 'form');
    }
}
