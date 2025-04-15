<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Simulação de conexão com banco de dados
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "beautyfair";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Endpoint para produtos
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'products') {
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        
        if ($category && $category !== 'all') {
            $stmt = $conn->prepare("SELECT * FROM products WHERE category = :category");
            $stmt->bindParam(':category', $category);
        } else {
            $stmt = $conn->prepare("SELECT * FROM products");
        }
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($products);
        exit;
    }
    
    // Endpoint para login
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $email = $data['email'];
        $password = $data['password'];
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', md5($password)); // Nunca armazene senhas em texto puro na prática!
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
        }
        
        exit;
    }
    
    // Endpoint para cadastro
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        
        // Verificar se o usuário já existe
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Email já cadastrado']);
            exit;
        }
        
        // Inserir novo usuário
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', md5($password)); // Nunca armazene senhas em texto puro na prática!
        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso']);
        exit;
    }
    
    // Endpoint para contato
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'contact') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $name = $data['name'];
        $email = $data['email'];
        $subject = $data['subject'];
        $message = $data['message'];
        
        // Inserir mensagem no banco de dados
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'Mensagem enviada com sucesso']);
        exit;
    }
    
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Rota não encontrada
echo json_encode(['error' => 'Endpoint não encontrado']);
?>