<?php
    // Configurações do banco de dados
    $dsn = 'mysql:host=localhost;dbname=fashionmavens';
    $username = 'devs';
    $password = 'manilha';

    try {
        // Conexão com o banco de dados usando PDO
        $pdo = new PDO($dsn, $username, $password);
        
        // Configura para lançar exceções em caso de erros
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verifica se o formulário foi submetido
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do formulário
            $user = $_POST['user'];
            $nome = $_POST['nome'];
            $nasc = $_POST['nasc'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            
            // Prepara a consulta SQL
            $sql = "INSERT INTO cadastro (user, nome, nasc, email, senha) 
            VALUES (:user, :nome, :nasc, :email, :senha)";
            
            // Prepara a declaração
            $stmt = $pdo->prepare($sql);
            
            // Associa os parâmetros com os valores
            $stmt->bindValue(':user', $user, PDO::PARAM_STR);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':nasc', $nasc, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
            
            // Executa a consulta
            $stmt->execute();
            
            echo "Dados inseridos com sucesso!";
        }
    } catch(PDOException $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo "Erro: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Fashion Maven's - Login</title>
    <link 
    href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" 
    rel="stylesheet"
    >
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4">Login:</h2>
        <form method="POST" class="max-w-lg">
            <div class="mb-4">
                <label for="user" class="block text-gray-700">@ do Usuário:</label>
                <input type="text" id="user" name="user" required class="form-input mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label for="nome" class="block text-gray-700">Nome:</label>
                <input type="text" id="nome" name="nome" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="nasc" class="block text-gray-700">Data de Nascimento:</label>
                <input type="date" id="nasc" name="nasc" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700">E-mail:</label>
                <input type="email" id="email" name="email" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="senha" class="block text-gray-700">Senha:</label>
                <input type="password" id="senha" name="senha" required class="form-input mt-1 block w-full">
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enviar</button>
        </form>
    </div>
</body>
</html>