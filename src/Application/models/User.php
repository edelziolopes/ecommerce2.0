<?php

namespace Application\models;

use Application\core\Database;
use PDO;

class User
{
    public function registrar($nome, $email, $senha)
    {
        $db = new Database();
        
        // Verifica se e-mail já existe
        $check = $db->executeQuery("SELECT id FROM usuarios WHERE email = :email", ['email' => $email]);
        if ($check->rowCount() > 0) {
            return false; // E-mail já existe
        }

        // Criptografa a senha (Nunca salvar senha pura!)
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $db->executeQuery($sql, [
            'nome' => $nome,
            'email' => $email,
            'senha' => $hash
        ]);

        return true;
    }

    public function login($email, $senha)
    {
        $db = new Database();
        $result = $db->executeQuery("SELECT * FROM usuarios WHERE email = :email", ['email' => $email]);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        // Verifica se usuário existe e se a senha bate com o hash
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }

        return false;
    }
}