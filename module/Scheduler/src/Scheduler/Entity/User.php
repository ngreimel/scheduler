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
class User extends Base
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
     * Set defaults
     */
    public function __construct() {
        $this->status = 2;
        $this->role = 2;

        return $this;
    }
}
