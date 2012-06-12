<?php
return function($class) 
{
    $filepath = str_replace('\\', '/', $class) . '.php';
    if (file_exists($filepath)) {
        require_once $filepath;
    } else {
        foreach (explode(PATH_SEPARATOR, ini_get("include_path")) as $path) {
            if (strlen($path) > 0 && $path{strlen($path)-1} != DS) {
                $path .= DS;
            }
            $realPath = realpath($path . $filepath);
            if ($realPath && is_file($realPath)) {
                require_once $realPath;
            }
        }
    }
};