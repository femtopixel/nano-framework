<?php
namespace Nano;

class Basepath
{
    public static function get()
    {
        $scriptName = $_SERVER['SCRIPT_FILENAME'];
        $documentRoot = str_replace(basename($scriptName), '', $scriptName);
        $uri = $_SERVER['REQUEST_URI'];
        $length = strlen($uri);
        $basePath = '/';
        for ($i = 1; $i <= $length; $i++) {
            $currentBasePath = substr($uri, 0, $i);
            $found = strpos($documentRoot, $currentBasePath);
            if ($found === false) {
                break;
            }
            $basePath = $currentBasePath;
        }
        $length = strlen($basePath) - 1;
        if ($basePath{$length} != '/') {
            $basePath .= '/';
        }
        return $basePath;
    }
}
