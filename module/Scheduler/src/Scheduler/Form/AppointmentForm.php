<?php

namespace Scheduler\Form;

use Zend\Form\Form;

class AppointmentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('appointment');

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

        $this->add(array(
            'name' => 'event_id',
            'type' => 'text',
            'options' => array(
                'label' => 'Event Id',
            ),
            'attributes' => array(
                'id'    => 'event_id',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));

        $this->setAttribute('role', 'form');
    }
}
