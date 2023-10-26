<?php
    namespace sparkbits\autoloader;
    use RecursiveIteratorIterator;
    use RecursiveDirectoryIterator;

    class Manifestbuilder
    {
        protected string $rootPath;
        protected array $candidates = [];
        protected string $path;
        protected array $exclude;

        public function __construct(string $root, $exclude = [], $file = "./manifest.properties")
        {
            $this->rootPath = $root;
            $this->path = $file;
            $this->exclude = $exclude;
        }
        public function __destruct() {}

        public function run()
        {
            $files = $this->scanDirectories();
            foreach($files as $file) {
                $namespaces = $this->extractItem($file,"/^\s*class\s+(\w+)/");
                foreach($namespaces as $namespace) {
                    if (!$this->exitsts($namespace)) {
                        echo($namespace[0] . "_" . $namespace[1] . "==>" . $namespace[2]) . PHP_EOL;
                        $this->addCandidate($namespace);
                    }
                }
                $namespaces = $this->extractItem($file,"/^\s*interface\s+(\w+)/");
                foreach($namespaces as $namespace) {
                    if (!$this->exitsts($namespace)) {
                        echo($namespace[0] . "_" . $namespace[1] . "==>" . $namespace[2]) . PHP_EOL;
                        $this->addCandidate($namespace);
                    }
                }
            }
            $this->save($this->path);
        }
        protected function save($path)
        {
            $content = json_encode($this->candidates, JSON_PRETTY_PRINT, 512);
            if ($content) {
                return file_put_contents($path, $content);
            }
        }
        protected function addCandidate(array $candidate)
        {
            $index = str_replace("\\","_",$candidate[0] . "_" . $candidate[1]);
            $this->candidates[$index] = $candidate[2];
        }
        protected function exitsts(array $candidate) : bool
        {
            if (empty($candidate)) return TRUE;
            $index = str_replace("\\","_",$candidate[0] . "_" . $candidate[1]);
            return array_key_exists($index, $this->candidates);
        }

        protected function scanDirectories() : array
        {
            $candidates = [];
            if (!is_dir($this->rootPath)) {
                return [];
            }
            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->rootPath));
            foreach($rii as $file) {
                if ($file->getfilename() == ".." || $file->getfilename() == ".") {
                    continue;
                }
                $continue = TRUE;
                foreach($this->exclude as $exclude) {
                    if (strpos($file,$exclude) === 0) {
                        $continue = FALSE;
                        break;
                    }
                }
                if (!$continue) continue;
                if (is_dir($file)) {
                    continue;
                }
                if ($file->getExtension() === "php") {
                    $candidates[] = $file->getPathname();
                }
            }
            return $candidates;
        }
        //Note we need to extract the class Names of the file
        protected function extractItem($file,$itempattern) : array
        {
            $candidates = [];
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            //$pattern = '/namespace\s+([^;]+);/';
            $pattern = '/^\s*namespace\s+([0-9A-Za-z_\\\\]+);/';
            // Loop through each line and check for a match
            $namespace = "";
            foreach ($lines as $line) {
                if (preg_match($pattern, $line, $matches)) {
                        $namespace = $matches[1];
                        break;
                }
            }
            if ($namespace === "") {
                return $candidates;
            }
            //Scan Class
            $pattern = '/^\s*class\s+(\w+)/';
            foreach ($lines as $line) {
                if (preg_match($itempattern, $line, $matches)) {
                        $class = $matches[1];
                        $candidates[] = array($namespace, $class, $file);
                }
            }
            return $candidates;
        }

    }
?>