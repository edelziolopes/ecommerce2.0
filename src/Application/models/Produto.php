<?php

namespace Application\models;

use Application\core\Database;
use PDO;

class Produto
{
    public function listarTodos()
    {
        $conn = new Database();
        $result = $conn->executeQuery('SELECT * FROM produtos WHERE quantidade_estoque > 0');
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $conn = new Database();
        $result = $conn->executeQuery('SELECT * FROM produtos WHERE id = :id', ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

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

    // --- NOVO MÉTODO DE FILTRO COMBINADO ---
    public function filtrarAvancado($categoria = null, $min = null, $max = null)
    {
        $conn = new Database();
        $sql = "SELECT * FROM produtos WHERE quantidade_estoque > 0";
        $params = [];

        // Filtro de Categoria
        if ($categoria && $categoria !== 'todos') {
            $sql .= " AND categoria_id = :cat";
            $params['cat'] = $categoria;
        }

        // Filtro de Preço Mínimo
        if ($min !== null && $min !== '') {
            $sql .= " AND preco >= :min";
            $params['min'] = $min;
        }

        // Filtro de Preço Máximo
        if ($max !== null && $max !== '') {
            $sql .= " AND preco <= :max";
            $params['max'] = $max;
        }

        $result = $conn->executeQuery($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}   