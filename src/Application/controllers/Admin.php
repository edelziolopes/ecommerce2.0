<?php

namespace Application\controllers;

use Application\core\Controller;

class Admin extends Controller
{
    private $adminModel;

    public function __construct()
    {
        // Verifica se está logado e se é o usuário ID 1 (Admin)
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            $this->redirect('');
            exit;
        }

        $this->adminModel = $this->model('AdminModel');
    }

    public function index()
    {
        $stats = $this->adminModel->getStats();
        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    public function produtos()
    {
        $produtoModel = $this->model('Produto');
        
        // DICA: O ideal seria ter um método listarTodosSemFiltro() para o admin ver produtos com estoque zero
        // mas vamos manter o padrão por enquanto.
        $dados = [
            'produtos' => $produtoModel->listarTodos(),
            'categorias' => $produtoModel->listarCategorias()
        ];
        $this->view('admin/produtos', $dados);
    }

    public function salvar_produto()
    {
        $dados = $_POST;
        // Inicializa imagem vazia (para o Model saber se mantém a antiga ou não)
        $dados['imagem'] = '';

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid() . '.' . $ext;
            
            // --- CORREÇÃO DO CAMINHO ---
            // Caminho relativo a partir de public/index.php
            $pastaDestino = 'assets/img/';
            
            // Garante que a pasta existe (cria se não existir)
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0777, true);
            }

            $destinoFinal = $pastaDestino . $novoNome;
            
            // Tenta mover o arquivo
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destinoFinal)) {
                $dados['imagem'] = $novoNome;
            }
        }

        $this->adminModel->salvarProduto($dados);
        $this->redirect('admin/produtos');
    }

    public function deletar_produto($id)
    {
        $this->adminModel->deletarProduto($id);
        $this->redirect('admin/produtos');
    }

    public function categorias()
    {
        $produtoModel = $this->model('Produto');
        $categorias = $produtoModel->listarCategorias();
        $this->view('admin/categorias', ['categorias' => $categorias]);
    }

    public function salvar_categoria()
    {
        $id = $_POST['id'] ?? null;
        $nome = $_POST['nome'];
        $this->adminModel->salvarCategoria($id, $nome);
        $this->redirect('admin/categorias');
    }

    public function deletar_categoria($id)
    {
        $this->adminModel->deletarCategoria($id);
        $this->redirect('admin/categorias');
    }

    public function vendas()
    {
        try {
            $vendas = $this->adminModel->listarVendasCompleta();
            
            foreach ($vendas as &$venda) {
                $venda['itens'] = $this->adminModel->listarItensVenda($venda['id']);
            }
            unset($venda);

            $this->view('admin/vendas', ['vendas' => $vendas]);

        } catch (\Exception $e) {
             echo "Erro: " . $e->getMessage();
        }
    }
}