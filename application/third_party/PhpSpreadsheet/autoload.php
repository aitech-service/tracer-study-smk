<?php

spl_autoload_register(function ($class) {
    // Namespace PhpOffice\PhpSpreadsheet\
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = __DIR__ . '/src/PhpSpreadsheet/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Bukan namespace PhpSpreadsheet
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
