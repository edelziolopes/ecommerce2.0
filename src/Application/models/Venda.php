<?php

namespace Application\models;

use Application\core\Database;
use PDO;

class Venda
{
    public function buscarPorUsuario($usuarioId)
    {
        $db = new Database();
        $sql = "SELECT * FROM vendas WHERE usuario_id = :uid ORDER BY data_venda DESC";
        $result = $db->executeQuery($sql, ['uid' => $usuarioId]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarItens($vendaId)
    {
        $db = new Database();
        $sql = "SELECT iv.*, p.nome as produto_nome, p.imagem 
                FROM itens_venda iv
                JOIN produtos p ON iv.produto_id = p.id
                WHERE iv.venda_id = :id";
        $result = $db->executeQuery($sql, ['id' => $vendaId]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buscarPorId($id)
    {
        $db = new Database();
        $sql = "SELECT * FROM vendas WHERE id = :id";
        $result = $db->executeQuery($sql, ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
