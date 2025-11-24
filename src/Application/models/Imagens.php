<?php

namespace Application\models;
use Application\core\Database;
use PDO;
class Imagens
{
  public static function findAll()
  {
    $conn = new Database();
    $result = $conn->executeQuery('SELECT * FROM tb_imagens');
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
