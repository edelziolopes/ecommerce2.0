<?php

namespace Application\controllers;

use Application\core\Controller;

class Home extends Controller
{
    public function index()
    {
        $produtoModel = $this->model('Produto');
        
        $dados = [
            'produtos' => $produtoModel->listarTodos(),
            'categorias' => $produtoModel->listarCategorias()
        ];

        $this->view('home/index', $dados);
    }

    public function filtrar($id = null)
    {
        // --- CORREÇÃO AQUI ---
        // Limpa (apaga) qualquer HTML que o index.php tenha gerado até agora
        // garantindo que apenas o JSON seja enviado.
        ob_clean(); 
        // ---------------------

        $produtoModel = $this->model('Produto');
        $produtos = [];

        if (!$id || $id === 'todos') {
            $produtos = $produtoModel->listarTodos();
        } else {
            $produtos = $produtoModel->listarPorCategoria($id);
        }

        header('Content-Type: application/json');
        echo json_encode($produtos);
        exit;
    }
}