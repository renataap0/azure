<?php
$servername = "localhost";
$username = "username";
$password = "password";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criar banco de dados se não existir
    $sql = "CREATE DATABASE IF NOT EXISTS beautyfair";
    $conn->exec($sql);
    
    // Conectar ao banco de dados beautyfair
    $conn = new PDO("mysql:host=$servername;dbname=beautyfair", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criar tabela de usuários
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    
    // Criar tabela de produtos
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category VARCHAR(20) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        old_price DECIMAL(10,2),
        image VARCHAR(255) NOT NULL,
        description TEXT,
        badge VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    
    // Criar tabela de contatos
    $sql = "CREATE TABLE IF NOT EXISTS contacts (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    
    // Inserir alguns produtos de exemplo (apenas na primeira execução)
    $stmt = $conn->prepare("SELECT COUNT(*) FROM products");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $products = [
            [
                'name' => 'Creme Facial Hidratante',
                'category' => 'skincare',
                'price' => 89.90,
                'old_price' => 99.90,
                'image' => 'images/produtos/creme-facial.jpg',
                'description' => 'Creme facial hidratante com ácido hialurônico para pele seca.',
                'badge' => 'Novo'
            ],
            // Adicionar outros produtos conforme necessário
        ];
        
        foreach ($products as $product) {
            $stmt = $conn->prepare("INSERT INTO products (name, category, price, old_price, image, description, badge) 
                                   VALUES (:name, :category, :price, :old_price, :image, :description, :badge)");
            $stmt->execute($product);
        }
    }
    
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>