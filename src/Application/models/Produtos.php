<?php
namespace Application\models;
use Application\core\Database;
use PDO;
class Produtos
{
  public static function findAll()
  {
    $conn = new Database();
    $result = $conn->executeQuery('
    SELECT * FROM tb_produtos'
  );
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function findIndex()
  {
    $conn = new Database();
    $result = $conn->executeQuery('
    SELECT 
    p.id AS produto_id,
    p.nome AS produto_nome,
    p.descricao AS produto_descricao,
    p.preco AS produto_preco,
    c.nome AS categoria_nome,
    i.link AS imagem_link
    FROM tb_produtos p
    LEFT JOIN tb_categorias c 
    ON p.id_categoria = c.id
    LEFT JOIN tb_imagens i 
    ON p.id = i.id_produto;
    '
  );
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
