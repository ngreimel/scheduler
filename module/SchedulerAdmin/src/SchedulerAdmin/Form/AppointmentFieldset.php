<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Form;

use Scheduler\Entity\Appointment;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AppointmentFieldset
    extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('appointment');

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new Appointment());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'rei',
            'type' => 'Text',
            'options' => array(
                'label' => 'REI #',
                'label_attributes' => array(
                    'class' => 'control-label',
                ),
            ),
            'attributes' => array(
                'id'    => 'rei',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'work_description',
            'type' => 'TextArea',
            'options' => array(
                'label' => 'Description of Work',
                'label_attributes' => array(
                    'class' => 'control-label',
                ),
            ),
            'attributes' => array(
                'id'    => 'work_description',
                'class' => 'form-control',
            ),
        ));

        $locationFieldset = new LocationFieldset($objectManager);
        $this->add($locationFieldset);

        $userFieldset = new UserFieldset($objectManager);
        $this->add($userFieldset);
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

            'rei' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 45,
                        ),
                    ),
                ),
            ),

            'work_description' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                ),
            ),
        );
    }
}
