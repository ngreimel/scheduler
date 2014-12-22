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
class Event extends Base
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
     * @ORM\ManyToOne(targetEntity="Appointment", cascade={"persist"})
     */
    protected $appointment;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * Return created_at date
     *
     * @return \DateTime
     */
    public function getCreated_at()
    {
        if (!$this->created_at) {
            $this->created_at = new \DateTime('now');
        }

        return $this->created_at;
    }

    /**
     * Return status: (0 => canceled, 1 => active, 2 => pending, 3 => complete)
     *
     * @return int
     */
    public function getStatus()
    {
        if (null === $this->status) {
            $this->status = 2;
        }

        return $this->status;
    }
}
