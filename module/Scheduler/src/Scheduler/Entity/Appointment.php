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
class Appointment extends Base
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
     * @ORM\ManyToOne(targetEntity="Location", cascade={"persist"})
     */
    protected $location;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     */
    protected $user;

}
