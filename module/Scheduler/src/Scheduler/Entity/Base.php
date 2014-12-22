<?php
/**
 * Scheduler Module
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace Scheduler\Entity;

/**
 * An abstract class that provides getters and setters
 */
class Base
{
    /**
     * Magic method to get/set protected properties.
     *
     * @param string $name
     * @param mixed $args
     * @return $this
     */
    public function __call($name, $args = array())
    {
        if (3 < strlen($name)) {
            $prefix = substr($name, 0, 3);
            $property = strtolower(substr($name, 3));
            if (property_exists($this, $property)) {
                switch ($prefix) {
                    case 'get':
                        return $this->$property;
                        break;
                    case 'set':
                        $this->$property = $args[0];
                        break;
                    default:
                        break;
                }
            }
        }

        return $this;
    }

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
     * @return $this
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
        return $this;
    }
}
