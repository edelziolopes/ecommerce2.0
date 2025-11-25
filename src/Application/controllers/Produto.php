<?php

namespace Application\controllers;

use Application\core\Controller;

class Produto extends Controller
{
    // Método padrão (opcional, redireciona para home)
    public function index()
    {
        $this->redirect('');
    }

    // Método para exibir detalhes de um produto específico
    // Rota esperada: /produto/detalhes/{id}
    public function detalhes($id = null)
    {
        if (!$id) {
            $this->redirect('');
            return;
        }

        // Instancia o model
        $produtoModel = $this->model('Produto');
        
        // Busca o produto pelo ID
        $produto = $produtoModel->buscarPorId($id);

        if (!$produto) {
            $this->pageNotFound();
            return;
        }

        // Carrega a view de detalhes
        $this->view('produto/detalhes', ['produto' => $produto]);
    }
}