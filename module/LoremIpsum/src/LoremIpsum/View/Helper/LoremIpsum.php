<?php
/**
 * Lorem Ipsum Generator
 * @todo - Find a better way to load the text file
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace LoremIpsum\View\Helper;

use Zend\View\Helper\AbstractHelper;

class LoremIpsum extends AbstractHelper
{
    const RAND_MIN = 20;
    const RAND_MAX = 50;
    const FILE_NAME = 'LoremIpsum.txt';

    /**
     * Returns 'lorem ipsum ...' text, formatted as a sentence/paragraph
     * - Accepts two parameters:
     *
     * @param  int  $length     Number of words returned
     * @param  bool $random     Start from the beginning?
     *
     * @return string
     */
    public function __invoke($length = null, $random = false)
    {
        // Load the text into an array
        $lorem = explode(' ', $this->_getText());

        // If length isn't set, pick a random number
        if (null === $length) {
            $length = rand(self::RAND_MIN, self::RAND_MAX);
        }

        // Calculate the offset
        $offset = ($random) ? rand(0, count($lorem) - $length) : 0;

        // Assemble!
        $text = implode(' ', array_slice($lorem, $offset, $length));

        // Format
        $text[0] = strtoupper($text[0]);
        $text = rtrim($text, '.,') . '.';

        return $text;
    }

    /**
     * Load lorem ipsum text from file
     *
     * @return text
     */
    protected function _getText()
    {
        if (!isset($this->_text)) {
            $this->_text = file_get_contents(
                realpath(dirname(__FILE__) . '/../../../../data/' . self::FILE_NAME)
            );
        }

        return $this->_text;
    }
}
