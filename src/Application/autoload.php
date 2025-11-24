<?php

spl_autoload_register(function ($filename) {
    $file = '..' . DIRECTORY_SEPARATOR . $filename . '.php';
    if (DIRECTORY_SEPARATOR === '/') {
        $file = str_replace('\\', '/', $file);
    }

    if (file_exists($file)) {
        require $file;
    } else {
        // Retorna false para indicar que o arquivo não foi encontrado
        return false;
    }
});
