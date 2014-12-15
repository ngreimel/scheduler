<?php
/**
 * CacheBusting Module - nealgreimel.com
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 * @version     $Id$
 */

namespace CacheBust\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CacheBust extends AbstractHelper
{
    /**
     * Takes a file path (relative to document root) and adds versioning
     * string
     *
     * @param  string
     * @return string
     */
    public function __invoke($path)
    {
        $docroot = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists($docroot . $path)) {
            $mtime = filemtime($docroot . $path);
            $pathinfo = pathinfo($path);
            $path = $pathinfo['dirname'] . '/' . $pathinfo['filename']
                  . '.' . $mtime . '.' . $pathinfo['extension'];
        }

        return $path;
    }
}
