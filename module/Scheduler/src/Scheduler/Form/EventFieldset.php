<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Form;

use Scheduler\Entity\Event;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EventFieldset
    extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('event');

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new Event());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'Date',
            'options' => array(
                'label' => 'Date',
            ),
            'attributes' => array(
                'id'    => 'date',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'time',
            'type' => 'Time',
            'options' => array(
                'label' => 'Time',
            ),
            'attributes' => array(
                'id'    => 'time',
                'class' => 'form-control',
            ),
        ));

        $appointmentFieldset = new AppointmentFieldset($objectManager);
        $this->add($appointmentFieldset);
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ),

            'date' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'Date'),
                ),
            ),

            'time' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'Date'),
                ),
            ),
        );
    }
}
