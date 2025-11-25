<?php

namespace Application\controllers;

use Application\core\Controller;
use Application\core\Database;
use PDO;
use Exception;

class Checkout extends Controller
{
    public function finalizar()
    {
        // 1. INICIA A SESSÃO SE NECESSÁRIO
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. VERIFICAÇÃO DE LOGIN
        // Se não existir 'user_id' na sessão, o usuário não está logado.
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return; 
        }

        // 3. VERIFICA CARRINHO
        if (empty($_SESSION['carrinho'])) {
            $this->redirect('');
            return;
        }

        $db = new Database();
        
        // --- CORREÇÃO DO BUG: USAR ID DA SESSÃO ---
        $usuarioId = $_SESSION['user_id']; 
        // ------------------------------------------

        $carrinho = $_SESSION['carrinho'];
        $total = 0;

        try {
            $db->executeQuery("BEGIN TRANSACTION");

            // Insere Venda
            $db->executeQuery("INSERT INTO vendas (usuario_id, total_venda) VALUES (:uid, 0)", ['uid' => $usuarioId]);
            
            // Pega ID
            $res = $db->executeQuery("SELECT last_insert_rowid() as id");
            $vendaId = $res->fetch(PDO::FETCH_ASSOC)['id'];

            $produtoModel = $this->model('Produto');

            foreach ($carrinho as $prodId => $qtd) {
                $prodData = $produtoModel->buscarPorId($prodId);

                if (!$prodData) {
                    throw new Exception("Produto ID $prodId não encontrado.");
                }

                if ($prodData['quantidade_estoque'] < $qtd) {
                    throw new Exception("Estoque insuficiente para o produto: " . $prodData['nome']);
                }

                $subtotal = $prodData['preco'] * $qtd;
                $total += $subtotal;

                // Insere Item
                $sqlItem = "INSERT INTO itens_venda (venda_id, produto_id, quantidade, preco_unitario) VALUES (:vid, :pid, :qtd, :preco)";
                $db->executeQuery($sqlItem, [
                    'vid' => $vendaId,
                    'pid' => $prodId,
                    'qtd' => $qtd,
                    'preco' => $prodData['preco']
                ]);

                // Baixa Estoque
                $sqlUpdate = "UPDATE produtos SET quantidade_estoque = quantidade_estoque - :qtd WHERE id = :id";
                $db->executeQuery($sqlUpdate, [
                    'qtd' => $qtd,
                    'id'  => $prodId
                ]);
            }

            // Atualiza Total
            $db->executeQuery("UPDATE vendas SET total_venda = :total WHERE id = :id", [
                'total' => $total,
                'id' => $vendaId
            ]);

            $db->executeQuery("COMMIT");
            unset($_SESSION['carrinho']);

            // Tela de Sucesso
            echo "<div style='font-family:sans-serif; text-align:center; padding:50px;'>";
            echo "<h1 style='color:green'>Compra Realizada!</h1>";
            echo "<p>Venda #$vendaId confirmada para o usuário ID: $usuarioId.</p>";
            echo "<a href='/'>Voltar a loja</a>";
            echo "</div>";

        } catch (Exception $e) {
            $db->executeQuery("ROLLBACK");
            echo "Erro na venda: " . $e->getMessage();
        }
    }
}