<?php
// Configurações do banco de dados
$dsn = 'mysql:host=localhost:3306;dbname=fashionmavens';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // Verifica se o nome de usuário existe no banco de dados
        $sql = "SELECT * FROM cadastro WHERE user = :user";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if ($senha === $usuario['senha']) {
                echo json_encode(['success' => true, 'message' => 'Login bem-sucedido!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Senha incorreta!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuário não encontrado!']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>