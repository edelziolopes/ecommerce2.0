<?php

namespace Application\core;

use PDO;
use PDOException;

class Database extends PDO
{
  private $DB_NAME = '';
  private $DB_USER = '';
  private $DB_PASSWORD = '';
  private $DB_HOST = '';
  private $DB_PORT = 3306;

  private $conn;

  public function __construct()
  {
    try {
      $this->conn = new PDO("mysql:host=$this->DB_HOST;dbname=$this->DB_NAME", $this->DB_USER, $this->DB_PASSWORD, [PDO::ATTR_PERSISTENT => true]);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die('Erro de conexão com o banco de dados: ' . $e->getMessage());
    }
  }

  private function setParameters($stmt, $key, $value)
  {
    $stmt->bindParam($key, $value);
  }

  private function mountQuery($stmt, $parameters)
  {
    foreach ($parameters as $key => $value) {
      $this->setParameters($stmt, $key, $value);
    }
  }

  public function executeQuery(string $query, array $parameters = [])
  {
    try {
      $stmt = $this->conn->prepare($query);
      $this->mountQuery($stmt, $parameters);
      $stmt->execute();
      return $stmt;
    } catch (PDOException $e) {
      die('Erro ao executar a query: ' . $e->getMessage());
    }
  }

  public function closeConnection()
  {
    if ($this->conn) {
      $this->conn = null;
    }
  }

  public function __destruct()
  {
    $this->closeConnection();
  }
}