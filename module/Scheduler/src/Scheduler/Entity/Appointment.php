<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Entity;

use Doctrine\ORM\Mapping as ORM;

#use Scheduler\Entity\Location;
#use Scheduler\Entity\User;

/**
 * An appointment.
 *
 * @ORM\Entity
 * @ORM\Table(name="appointment")
 * @property int      $id
 * @property text     $rei
 * @property text     $work_description
 * @property Location $location
 * @property User     $user
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=60)
     */
    protected $rei;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $work_description;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     */
    protected $location;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;


    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     * @return Appointment
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
        return $this;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     * @return Appointment
     */
    public function exchangeArray($data = array())
    {
        $this->id               = $data['id'];
        $this->rei              = $data['rei'];
        $this->work_description = $data['work_description'];
        $this->location         = $data['location'];
        $this->user             = $data['user'];

        return $this;
    }
}
