<?php

define('PATH_LIB', getenv('APP_DIR') . '/lib');
require PATH_LIB . '/Twig/AutoLoader.php';
Twig_Autoloader::register();
require PATH_LIB . '/TwigHelper.php';

/**
 * $haystackは$needleで終わる？
 */
function ends_with($haystack, $needle)
{
    return (strlen($haystack) > strlen($needle)) ? (substr($haystack, -strlen($needle)) == $needle) : false;
}
