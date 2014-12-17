<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * An event.
 *
 * @ORM\Entity
 * @ORM\Table(name="event")
 * @property int         $id
 * @property date        $date
 * @property time        $time
 * @property datetime    $created_at
 * @property Appointment $appointment
 * @property int         $status
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\Column(type="time")
     */
    protected $time;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Appointment")
     */
    protected $appointment;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;


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
     * @return Event
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
     * @return Event
     */
    public function exchangeArray($data = array())
    {
        $this->id          = $data['id'];
        $this->date        = new \DateTime($data['date']);
        $this->time        = new \DateTime($data['time']);
        $this->created_at  = new \DateTime($data['datetime']);
        $this->appointment = $data['appointment'];
        $this->status      = $data['status'];

        return $this;
    }
}
