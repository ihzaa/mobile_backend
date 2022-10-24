<?php
if (!function_exists('readSubDir')) {
    function readSubDir($dir, array $subDirs)
    {
        foreach ($subDirs as $k => $d) {
            $subDir = $dir . '/' . $d;
            $files = scandir($subDir);
            $dirs = [];
            foreach ($files as $k => $file) {
                if (!in_array($file, array('index.php')) && strpos($file, '.php') !== false) {
                    require $subDir . '/' . $file;
                }
                if (!in_array($file, array('.', '..')) && strpos($file, '.php') === false) {
                    array_push($dirs, $file);
                }
            };
            if ($dirs != []) {
                readSubDir($subDir, $dirs);
            }
        };
    }
}
