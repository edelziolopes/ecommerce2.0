<?php

namespace Application\controllers;

use Application\core\Controller;

class Carrinho extends Controller
{
    public function index()
    {
        $carrinho = $_SESSION['carrinho'] ?? [];
        $dados = [];
        $total = 0;

        if (!empty($carrinho)) {
            $produtoModel = $this->model('Produto');
            
            foreach ($carrinho as $id => $qtd) {
                $produto = $produtoModel->buscarPorId($id);
                if ($produto) {
                    $produto['qtd_carrinho'] = $qtd;
                    $produto['subtotal'] = $produto['preco'] * $qtd;
                    $total += $produto['subtotal'];
                    $dados[] = $produto;
                }
            }
        }

        $this->view('carrinho/index', ['itens' => $dados, 'total' => $total]);
    }

    public function adicionar($id)
    {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Lógica simples: incrementa quantidade
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]++;
        } else {
            $_SESSION['carrinho'][$id] = 1;
        }

        $this->redirect('carrinho');
    }

    public function remover($id)
    {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
        $this->redirect('carrinho');
    }
    
    public function limpar()
    {
        unset($_SESSION['carrinho']);
        $this->redirect('carrinho');
    }
}