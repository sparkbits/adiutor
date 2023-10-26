<?php

    class Autoloader
    {
        public static function registerClass($className)
        {
            //Business Logic here
            $path = __DIR__ . DIRECTORY_SEPARATOR . 'manifest.properties';
            if (file_exists($path) == FALSE) {
                throw new RuntimeException("properties file not found on $path");
            } else {
                $manifest = json_decode(file_get_contents($path), TRUE);
                if (is_null($manifest) === TRUE) {
                    throw new RuntimeException("invalid properties file on $path");
                }
                $classPath = str_replace("\\",DIRECTORY_SEPARATOR,$className);
                $index = str_replace(DIRECTORY_SEPARATOR,"_",dirname($classPath)) . "_" . basename($classPath);
                if ($index === "._" . basename($className)) {
                    //Classes without namespace
                    $index = basename($className);
                }
                if (array_key_exists($index,$manifest) == TRUE) {
                    $path = $manifest[$index];
                    if (file_exists($path) == TRUE) {
                        require_once($path);
                        return;
                    } else {
                        throw new RuntimeException("file $path not found");
                    }
                }
                //Try to check current path of Main Script.
                if (file_exists(getcwd() . DIRECTORY_SEPARATOR . basename($className) . ".php")) {
                    require_once(getcwd() . DIRECTORY_SEPARATOR . basename($className) . ".php");
                    return;
                }
                throw new RuntimeException("unable to load class  $className");
            }
        }
    }
    spl_autoload_register(array('AutoLoader', 'registerClass'));
?>