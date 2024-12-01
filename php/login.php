<?php
session_start();
header('Content-Type: application/json');
include 'conection.php';



// Obtém o corpo da requisição JSON
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Coleta os dados enviados
$user = $data['user'] ?? null;
$senha = $data['senha'] ?? null;

if (!$user || !$senha) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
    exit;
}

try {
    // Verifica se o nome de usuário existe no banco de dados
    $sql = "SELECT * FROM cadastro WHERE user = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $user, PDO::PARAM_STR);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Verifica se o userid é maior ou igual a 12
        if ($usuario['userid'] >= 12) {
            // Verifica a senha usando password_verify() apenas para usuários a partir do ID 12
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['user'] = [
                    'userid' => $usuario['userid'],
                    'user' => $usuario['user'],
                    'nome' => $usuario['nome']
                ];
                echo json_encode(['success' => true, 'message' => 'Login bem-sucedido!', 'redirect' => 'home.html']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Senha incorreta.']);
            }
        } else {
            if ($usuario && $senha === $usuario['senha']) {
                // A senha está correta
                $_SESSION['user'] = [
                    'userid' => $usuario['userid'],
                    'user' => $usuario['user'],
                    'nome' => $usuario['nome']
                ];
                echo json_encode(['success' => true, 'message' => 'Login bem-sucedido!', 'redirect' => 'home.html']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuário ou senha incorretos.']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}
