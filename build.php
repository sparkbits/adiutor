<?php
    namespace sparkbits\autoloader;
    use RuntimeException;

    require_once('Manifestbuilder.php');

    try
    {
        if (isset($argv[1]) == FALSE || isset($argv[2]) == FALSE)  {
            echo "Usage:" . $argv[0] . " <target path> <exclude path1, exclude path 2,...>";
            die(PHP_EOL);
        }
        $target = $argv[1];
        if (is_dir($target) == FALSE) {
            echo "Error: $target is not a valid directory.";
            die(PHP_EOL);
        }
        $exclude = explode(",",$argv[2]);
        foreach($exclude as $path) {
            if (is_dir($path) == FALSE) {
                echo "Error: $path is not a valid directory to exclude.";
                die(PHP_EOL);
            }
        }
        echo "Directory to Scan: " . realpath($target) . PHP_EOL;
        echo "Directories to exclude:" . PHP_EOL;
        $c = 1;
        foreach($exclude as $path) {
            if (realpath($target) == realpath($path)) {
                echo "Exclude path contains the target. Script Stopped";
                die(PHP_EOL);
            }
            echo $c++ . "-. ". realpath($path) . PHP_EOL;
        }
        $manifest = "./manifest.properties";
        $engine = new Manifestbuilder($target, $exclude, $manifest);
        $engine->run();
        echo "done";
    } catch (RuntimeException $e)
    {
        echo $e->getMessage();
    }
?>