<?php

function autoloader($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}

// Setup autoloader
spl_autoload_register("autoloader"); 

// Add current directory to include path
set_include_path(
                 realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." )
                 .PATH_SEPARATOR
                 .get_include_path()
                 );
