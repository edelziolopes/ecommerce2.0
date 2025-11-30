<?php

namespace Application\controllers;

use Application\core\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $vendaModel = $this->model('Venda');
        $vendas = $vendaModel->buscarPorUsuario($_SESSION['user_id']);

        $this->view('dashboard/index', ['vendas' => $vendas]);
    }

    public function detalhes($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $vendaModel = $this->model('Venda');
        $venda = $vendaModel->buscarPorId($id);

        if (!$venda || $venda['usuario_id'] != $_SESSION['user_id']) {
            // Venda não existe ou não pertence ao usuário
            $this->redirect('dashboard');
            return;
        }

        $itens = $vendaModel->buscarItens($id);
        $this->view('dashboard/detalhes', ['venda' => $venda, 'itens' => $itens]);
    }
}
