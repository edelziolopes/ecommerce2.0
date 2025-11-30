<?php
require 'src/Application/core/Database.php';

$db = new Application\core\Database();

echo "Querying with status = 1:\n";
$banners = $db->executeQuery("SELECT * FROM banners WHERE status = 1")->fetchAll(PDO::FETCH_ASSOC);
print_r($banners);

echo "Querying with status = '1':\n";
$banners = $db->executeQuery("SELECT * FROM banners WHERE status = '1'")->fetchAll(PDO::FETCH_ASSOC);
print_r($banners);

echo "Querying all:\n";
$banners = $db->executeQuery("SELECT id, status, hex(status) as hex_status FROM banners")->fetchAll(PDO::FETCH_ASSOC);
print_r($banners);
