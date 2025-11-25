<?php

namespace Application\controllers;

use Application\core\Controller;

class Auth extends Controller
{
    // Exibe formulário de login
    public function index() // rota: /auth ou /auth/login
    {
        $this->login();
    }

    public function login()
    {
        // Se já estiver logado, manda pra home
        if (isset($_SESSION['user_id'])) {
            $this->redirect('');
        }
        $this->view('auth/login');
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('');
        }
        $this->view('auth/register');
    }

    // Processa o Login
    public function entrar()
    {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $usuario = $userModel->login($email, $senha);

        if ($usuario) {
            // Salva dados na sessão
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nome'];
            
            // Se tiver itens no carrinho, manda pro carrinho, senão home
            if (!empty($_SESSION['carrinho'])) {
                $this->redirect('carrinho');
            } else {
                $this->redirect('');
            }
        } else {
            // Erro de login (Poderia passar msg de erro para a view)
            $this->view('auth/login', ['error' => 'E-mail ou senha inválidos']);
        }
    }

    // Processa o Cadastro
    public function salvar()
    {
        $nome = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['password'] ?? '';

        if (empty($nome) || empty($email) || empty($senha)) {
            $this->view('auth/register', ['error' => 'Preencha todos os campos']);
            return;
        }

        $userModel = $this->model('User');
        if ($userModel->registrar($nome, $email, $senha)) {
            // Cadastro sucesso, redireciona para login
            $this->redirect('auth/login');
        } else {
            $this->view('auth/register', ['error' => 'E-mail já cadastrado']);
        }
    }

    public function logout()
    {
        // Remove apenas dados do usuário, mantém carrinho se quiser, ou destroy tudo
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        
        // session_destroy(); // Use este se quiser limpar TUDO (inclusive carrinho)
        
        $this->redirect('');
    }
}