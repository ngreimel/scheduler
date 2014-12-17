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
 * A user.
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @property int  $id
 * @property text $email
 * @property text $first_name
 * @property text $last_name
 * @property text $phone
 * @property int  $status
 * @property int  $role
 */
class User
{
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=60)
     */
    protected $email;

    /**
     * @ORM\Column(type="text", length=45)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="text", length=45)
     */
    protected $last_name;

    /**
     * @ORM\Column(type="text", length=45)
     */
    protected $phone;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\Column(type="integer")
     */
    protected $role;


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
     * @return User
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
     * @return User
     */
    public function exchangeArray($data = array())
    {
        $this->id         = $data['id'];
        $this->email      = $data['email'];
        $this->first_name = $data['first_name'];
        $this->last_name  = $data['last_name'];
        $this->phone      = $data['phone'];
        $this->status     = $data['status'];
        $this->role       = $data['role'];

        return $this;
    }
}
