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
class Location
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
     * @return Location
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
     * @return Location
     */
    public function exchangeArray($data = array())
    {
        $this->id          = $data['id'];
        $this->street      = $data['street'];
        $this->city        = $data['city'];
        $this->state       = $data['state'];
        $this->zip         = $data['zip'];
        $this->access_type = $data['access_type'];
        $this->access_info = $data['access_info'];

        return $this;
    }
}
