<?php
    namespace sparkbits\autoloader;
    use RuntimeException;

    require_once('Manifestbuilder.php');

    try
    {
        $target = "/home/darvidor/Dev";
        $exclude = array(getcwd());
        $manifest = "./manifest.properties";
        $engine = new Manifestbuilder($target, $exclude, $manifest);
        $engine->run();
        echo "done";
    } catch (RuntimeException $e)
    {
        echo $e->getMessage();
    }
?>