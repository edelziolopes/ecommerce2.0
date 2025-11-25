<?php

require '../Application/autoload.php';
use Application\core\Database;

$db = new Database();

// Gera o hash correto da senha '123456'
$senhaHash = password_hash('123456', PASSWORD_DEFAULT);

// Atualiza o usuário ID 1 (Admin) com a senha criptografada
try {
    $db->executeQuery("UPDATE usuarios SET senha = :senha WHERE id = 1", [
        'senha' => $senhaHash
    ]);
    echo "<h1 style='color:green'>Senha do Admin atualizada com sucesso!</h1>";
    echo "<p>Agora você pode logar com: <strong>admin@loja.com</strong> / <strong>123456</strong></p>";
    echo "<a href='/auth/login'>Ir para Login</a>";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}