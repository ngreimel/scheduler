<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Form;

use Scheduler\Entity\Location;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class LocationFieldset
    extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('location');

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new Location());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'street',
            'type' => 'Text',
            'options' => array(
                'label' => 'Street address',
            ),
            'attributes' => array(
                'id'    => 'street',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'type' => 'Text',
            'options' => array(
                'label' => 'City',
            ),
            'attributes' => array(
                'id'    => 'city',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'state',
            'type' => 'Text',
            'options' => array(
                'label' => 'State',
            ),
            'attributes' => array(
                'id'    => 'state',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'zip',
            'type' => 'Text',
            'options' => array(
                'label' => 'ZIP',
            ),
            'attributes' => array(
                'id'    => 'zip',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'access_type',
            'type' => 'Text',
            'options' => array(
                'label' => 'Access Type',
            ),
            'attributes' => array(
                'id'    => 'access_type',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'access_info',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Access Information',
            ),
            'attributes' => array(
                'id'    => 'access_info',
                'class' => 'form-control',
            ),
        ));
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

            'street' => array(
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
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),

            'city' => array(
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
                            'min' => 1,
                            'max' => 45,
                        ),
                    ),
                ),
            ),

            'state' => array(
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
                            'min' => 1,
                            'max' => 45,
                        ),
                    ),
                ),
            ),

            'zip' => array(
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
                            'min' => 5,
                            'max' => 12,
                        ),
                    ),
                ),
            ),

            'access_type' => array(
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
                            'min' => 1,
                            'max' => 45,
                        ),
                    ),
                ),
            ),

            'access_info' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
        );
    }
}
