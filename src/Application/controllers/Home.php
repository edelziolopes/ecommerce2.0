<?php

namespace Application\controllers;

use Application\core\Controller;

class Home extends Controller
{
    public function index()
    {
        $produtoModel = $this->model('Produto');
        
        $adminModel = $this->model('AdminModel');

        $dados = [
            'produtos' => $produtoModel->listarTodos(),
            'categorias' => $produtoModel->listarCategorias(),
            'banners' => $adminModel->listarBannersAtivos()
        ];

        $this->view('home/index', $dados);
    }

    // --- ROTA DE FILTRO ATUALIZADA ---
    // Agora aceita POST JSON com múltiplos parâmetros
    public function filtrar()
    {
        ob_clean(); // Limpa buffer para garantir JSON puro

        // Lê o corpo da requisição JSON enviado pelo JavaScript
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $categoria = $data['categoria'] ?? 'todos';
        $min = $data['min'] ?? null;
        $max = $data['max'] ?? null;

        $produtoModel = $this->model('Produto');
        
        // Chama o novo método do Model
        $produtos = $produtoModel->filtrarAvancado($categoria, $min, $max);

        header('Content-Type: application/json');
        echo json_encode($produtos);
        exit;
    }
}