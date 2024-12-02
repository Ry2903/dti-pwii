<?php
session_start();
header('Content-Type: application/json');
include 'conection.php'; // Inclua sua conexão com o banco de dados aqui

// Recebe os dados via POST
$user = $_POST['user'] ?? null;
$nome = $_POST['nome'] ?? null;
$email = $_POST['email'] ?? null;
$nasc = $_POST['nasc'] ?? null;
$senha = $_POST['senha'] ?? null;

// Verificação 1: idade
//Se o usuário for menor de 13 anos, barra o cadastro
function validarIdade($dataNascimento)
{
    $dataAtual = new DateTime();
    $dataNasc = new DateTime($dataNascimento);
    $idade = $dataAtual->diff($dataNasc)->y;
    return $idade >= 13; // Retorna true se a idade for >= 13
}

if (!validarIdade($nasc)) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'É necessário ter pelo menos 13 anos para se cadastrar!'
    ]);
    exit;
}

// Verificação 2: validação do email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'E-mail inválido!'
    ]);
    exit;
}

// Validação da senha (mínimo de 8 caracteres)
if (strlen($senha) < 8) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'A senha deve ter pelo menos 8 caracteres!'
    ]);
    exit;
}

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

try {
    // Verifica se o usuário já existe
    $sql = "SELECT * FROM cadastro WHERE user = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $user, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário já existe.']);
        exit;
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO cadastro (user, nome, email, nasc, senha) VALUES (:user, :nome, :email, :nasc, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $user, PDO::PARAM_STR);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':nasc', $nasc, PDO::PARAM_STR);
    $stmt->bindValue(':senha', $senha_hash, PDO::PARAM_STR);
    $stmt->execute();

    // Retorna uma resposta de sucesso
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Cadastro realizado com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
}
