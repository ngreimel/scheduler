<?php
/**
 * Cache-Busting Helper
 * @todo - Find a better way to get doc root
 *
 * @author      Neal Greimel <neal@greimel.us>
 * @copyright   Copyright (c) 2014 Neal Greimel (http://neal.greimel.us)
 */

namespace CacheBust\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CacheBust extends AbstractHelper
{
    /**
     * Takes a file path (relative to document root) and adds a
     * cache-busting versioning string INTO the filename
     * - eg - cacheBust('/css/style.css') -> '/css/style.1234.css'
     *
     * *REQUIRES*
     *   RewriteRule (or similar) that removes the digits from the filename
     *   if it doesn't already exist
     *
     * @param  string
     * @return string
     */
    public function __invoke($path)
    {
        // Get the document root
        $docroot = $_SERVER['DOCUMENT_ROOT'];

        // Check that the file exists
        if (file_exists($docroot . $path)) {
            // Find the file modification time (unix timestamp)
            $mtime = filemtime($docroot . $path);
            $pathinfo = pathinfo($path);
            // Assemble new path, inserting mtime before extension
            $path = $pathinfo['dirname'] . '/' . $pathinfo['filename']
                  . '.' . $mtime . '.' . $pathinfo['extension'];
        }

        return $path;
    }
}
