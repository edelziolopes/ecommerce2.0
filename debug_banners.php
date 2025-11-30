<?php
require 'src/Application/core/Database.php';

try {
    $db = new Application\core\Database();
    $banners = $db->executeQuery('SELECT * FROM banners')->fetchAll(PDO::FETCH_ASSOC);
    echo "Banners in DB:\n";
    print_r($banners);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
