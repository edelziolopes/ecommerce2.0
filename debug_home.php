<?php
// Mocking necessary parts
session_start();
$_SESSION['user_id'] = 1;

require 'src/Application/core/Database.php';
require 'src/Application/core/Controller.php';
require 'src/Application/models/Produto.php';
require 'src/Application/models/AdminModel.php';
require 'src/Application/controllers/Home.php';

use Application\controllers\Home;

$home = new Home();
// We need to expose the data to check it, but the controller renders a view.
// Let's modify the controller temporarily or just instantiate the model directly here.

$adminModel = new Application\models\AdminModel();
$banners = $adminModel->listarBannersAtivos();

echo "Banners from AdminModel::listarBannersAtivos:\n";
print_r($banners);
