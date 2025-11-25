<?php

namespace Application\models;

use Application\core\Database;
use PDO;

class AdminModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // --- DASHBOARD ---
    public function getStats()
    {
        $stats = [];
        try {
            $stats['produtos'] = $this->db->executeQuery("SELECT COUNT(*) as total FROM produtos")->fetch(PDO::FETCH_ASSOC)['total'];
            $stats['vendas'] = $this->db->executeQuery("SELECT COUNT(*) as total FROM vendas")->fetch(PDO::FETCH_ASSOC)['total'];
            $stats['faturamento'] = $this->db->executeQuery("SELECT SUM(total_venda) as total FROM vendas")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            $stats['usuarios'] = $this->db->executeQuery("SELECT COUNT(*) as total FROM usuarios")->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (\Exception $e) {
            $stats = ['produtos' => 0, 'vendas' => 0, 'faturamento' => 0, 'usuarios' => 0];
        }
        return $stats;
    }

    // --- PRODUTOS ---
    public function salvarProduto($dados)
    {
        if (empty($dados['id'])) {
            $sql = "INSERT INTO produtos (categoria_id, nome, descricao, preco, quantidade_estoque, imagem) 
                    VALUES (:cat, :nome, :desc, :preco, :qtd, :img)";
            $params = [
                'cat' => $dados['categoria_id'],
                'nome' => $dados['nome'],
                'desc' => $dados['descricao'],
                'preco' => $dados['preco'],
                'qtd' => $dados['quantidade_estoque'],
                'img' => $dados['imagem']
            ];
        } else {
            $sql = "UPDATE produtos SET categoria_id = :cat, nome = :nome, descricao = :desc, 
                    preco = :preco, quantidade_estoque = :qtd";
            
            $params = [
                'cat' => $dados['categoria_id'],
                'nome' => $dados['nome'],
                'desc' => $dados['descricao'],
                'preco' => $dados['preco'],
                'qtd' => $dados['quantidade_estoque'],
                'id' => $dados['id']
            ];

            if (!empty($dados['imagem'])) {
                $sql .= ", imagem = :img";
                $params['img'] = $dados['imagem'];
            }

            $sql .= " WHERE id = :id";
        }

        return $this->db->executeQuery($sql, $params);
    }

    public function deletarProduto($id)
    {
        return $this->db->executeQuery("DELETE FROM produtos WHERE id = :id", ['id' => $id]);
    }

    // --- CATEGORIAS ---
    public function salvarCategoria($id, $nome)
    {
        if (empty($id)) {
            return $this->db->executeQuery("INSERT INTO categorias (nome) VALUES (:nome)", ['nome' => $nome]);
        } else {
            return $this->db->executeQuery("UPDATE categorias SET nome = :nome WHERE id = :id", ['nome' => $nome, 'id' => $id]);
        }
    }

    public function deletarCategoria($id)
    {
        return $this->db->executeQuery("DELETE FROM categorias WHERE id = :id", ['id' => $id]);
    }

    // --- VENDAS ---
    public function listarVendasCompleta()
    {
        $sql = "SELECT v.id, v.total_venda, v.data_venda, u.nome as cliente 
                FROM vendas v 
                JOIN usuarios u ON v.usuario_id = u.id 
                ORDER BY v.data_venda DESC";
                
        try {
            return $this->db->executeQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }

    // NOVO MÉTODO: Busca os itens de uma venda específica
    public function listarItensVenda($vendaId)
    {
        $sql = "SELECT iv.*, p.nome as produto_nome, p.imagem 
                FROM itens_venda iv
                JOIN produtos p ON iv.produto_id = p.id
                WHERE iv.venda_id = :id";
        return $this->db->executeQuery($sql, ['id' => $vendaId])->fetchAll(PDO::FETCH_ASSOC);
    }
}