<?php

namespace Application\models;

use Application\core\Database;
use PDO;

class Produto
{
    public function listarTodos()
    {
        $conn = new Database();
        // Busca apenas produtos com estoque positivo
        $result = $conn->executeQuery('SELECT * FROM produtos WHERE quantidade_estoque > 0');
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $conn = new Database();
        $result = $conn->executeQuery('SELECT * FROM produtos WHERE id = :id', ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // --- NOVOS MÉTODOS PARA O FILTRO ---

    public function listarCategorias()
    {
        $conn = new Database();
        $result = $conn->executeQuery('SELECT * FROM categorias ORDER BY nome ASC');
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorCategoria($categoriaId)
    {
        $conn = new Database();
        $result = $conn->executeQuery('SELECT * FROM produtos WHERE quantidade_estoque > 0 AND categoria_id = :id', ['id' => $categoriaId]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}