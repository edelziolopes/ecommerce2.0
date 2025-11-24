<?php

namespace Application\models;
use Application\core\Database;
use PDO;
class Categorias
{
  public static function findAll()
  {
    $conn = new Database();
    $result = $conn->executeQuery('SELECT * FROM tb_categorias');
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
