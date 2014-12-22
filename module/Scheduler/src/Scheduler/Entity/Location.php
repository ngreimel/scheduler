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
 * A location.
 *
 * @ORM\Entity
 * @ORM\Table(name="location")
 * @property int  $id
 * @property text $street
 * @property text $city
 * @property text $state
 * @property text $zip
 * @property text $access_type
 * @property text $access_info
 */
class Location extends Base
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $street;

    /**
     * @ORM\Column(type="text", length=45)
     */
    protected $city;

    /**
     * @ORM\Column(type="text", length=45)
     */
    protected $state;

    /**
     * @ORM\Column(type="text", length=12)
     */
    protected $zip;

    /**
     * @ORM\Column(type="text", length=45)
     */
    protected $access_type;

    /**
     * @ORM\Column(type="text", length=255)
     */
    protected $access_info;

}
