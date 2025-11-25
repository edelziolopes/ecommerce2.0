<?php

require '../Application/autoload.php';

use Application\core\Database;

// Configurações de exibição de erro
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Inicializando Banco de Dados SQLite...</h1>";

try {
    $db = new Database();
    
    // Array de comandos SQL
    $sqlCommands = [
        // --- 1. DROPS (Para limpar se já existir algo errado) ---
        "DROP TABLE IF EXISTS itens_venda",
        "DROP TABLE IF EXISTS vendas",
        "DROP TABLE IF EXISTS produtos",
        "DROP TABLE IF EXISTS categorias",
        "DROP TABLE IF EXISTS usuarios",

        // --- 2. CRIAÇÃO DAS TABELAS ---
        "CREATE TABLE usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            senha TEXT NOT NULL,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
        )",

        "CREATE TABLE categorias (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL
        )",

        "CREATE TABLE produtos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            categoria_id INTEGER,
            nome TEXT NOT NULL,
            descricao TEXT,
            preco REAL NOT NULL,
            imagem TEXT,
            quantidade_estoque INTEGER DEFAULT 0,
            FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        )",

        "CREATE TABLE vendas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            total_venda REAL,
            data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        )",

        "CREATE TABLE itens_venda (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            venda_id INTEGER,
            produto_id INTEGER,
            quantidade INTEGER NOT NULL,
            preco_unitario REAL NOT NULL,
            FOREIGN KEY (venda_id) REFERENCES vendas(id),
            FOREIGN KEY (produto_id) REFERENCES produtos(id)
        )",

        // --- 3. INSERÇÃO DE DADOS (SEEDS) ---
        
        // Categorias
        "INSERT INTO categorias (nome) VALUES ('Periféricos')",
        "INSERT INTO categorias (nome) VALUES ('Hardware')",
        "INSERT INTO categorias (nome) VALUES ('Games')",

        // Usuários
        "INSERT INTO usuarios (nome, email, senha) VALUES ('Administrador', 'admin@loja.com', '123456')",
        "INSERT INTO usuarios (nome, email, senha) VALUES ('Cliente Teste', 'cliente@teste.com', '123456')",

        // Produtos (Categoria 1 - Periféricos)
        "INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem, quantidade_estoque) 
         VALUES (1, 'Mouse Gamer RGB', 'Mouse com 12000 DPI', 150.00, 'mouse_rgb.jpg', 50)",
         
        "INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem, quantidade_estoque) 
         VALUES (1, 'Teclado Mecânico', 'Switch Blue ABNT2', 350.00, 'teclado_mec.jpg', 30)",

        // Produtos (Categoria 2 - Hardware)
        "INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem, quantidade_estoque) 
         VALUES (2, 'SSD NVMe 1TB', 'Leitura 3500MB/s', 600.00, 'ssd_1tb.jpg', 20)",
         
        "INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem, quantidade_estoque) 
         VALUES (2, 'Memória RAM 16GB', 'DDR4 3200MHz', 280.00, 'ram_16gb.jpg', 40)",

        // Produtos (Categoria 3 - Games)
        "INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem, quantidade_estoque) 
         VALUES (3, 'Console Portátil', 'Versão Oled 64GB', 2200.00, 'console.jpg', 10)"
    ];

    // Executa cada comando
    foreach ($sqlCommands as $sql) {
        $db->executeQuery($sql);
        echo "<p style='color: green'>Comando executado com sucesso: " . substr($sql, 0, 50) . "...</p>";
    }

    echo "<h2>Banco de dados configurado com sucesso!</h2>";
    echo "<a href='/'>Ir para a Loja</a>";

} catch (Exception $e) {
    echo "<h2 style='color: red'>Erro: " . $e->getMessage() . "</h2>";
}