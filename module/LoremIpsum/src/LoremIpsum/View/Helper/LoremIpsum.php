<?php
/**
 * LoremIpsum Module - nealgreimel.com
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 * @version     $Id$
 */

namespace LoremIpsum\View\Helper;

use Zend\View\Helper\AbstractHelper;

class LoremIpsum extends AbstractHelper
{
    protected function _getText()
    {
        if (!isset($this->_text)) {
            $this->_text = file_get_contents(realpath(dirname(__FILE__) . '/../../../../data/LoremIpsum.txt'));
        }

        return $this->_text;
    }

    /**
     *
     * @param  string
     * @return string
     */
    public function __invoke($length = null, $random = false)
    {
        $lorem = explode(' ', $this->_getText());

        $text = '';
        if (null === $length) {
            $length = rand(20, 50);
        }

        $offset = ($random) ? rand(0, count($lorem) - $length) : 0;

        $text = implode(' ', array_slice($lorem, $offset, $length));
        $text[0] = strtoupper($text[0]);
        $text = rtrim($text, '.,') . '.';

        return $text;
    }
}
