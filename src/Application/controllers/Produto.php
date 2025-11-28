<?php

namespace Application\controllers;

use Application\core\Controller;

class Produto extends Controller
{
    public function index()
    {
        $this->redirect('');
    }

    public function detalhes($id = null)
    {
        if (!$id) {
            $this->redirect('');
            return;
        }

        $produtoModel = $this->model('Produto');
        $produto = $produtoModel->buscarPorId($id);

        if (!$produto) {
            $this->pageNotFound();
            return;
        }

        // Carrega a view de detalhes
        $this->view('produto/detalhes', ['produto' => $produto]);
    }
}