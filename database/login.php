<?php
    // Configurações do banco de dados
    $dsn = 'mysql:host=localhost;dbname=fashionmavens';
    $username = 'root';
    $password = '';

    try {
            // Conexão com o banco de dados usando PDO
            $pdo = new PDO($dsn, $username, $password);
            
            // Configura para lançar exceções em caso de erros
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Verifica se o formulário foi submetido
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do formulário
            $user = $_POST['user'];
            $senha = $_POST['senha'];
            
            // Verifica se o nome de usuário existe no banco de dados
            $sql = "SELECT * FROM cadastro WHERE user = :user";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user', $user, PDO::PARAM_STR);
            $stmt->execute();

            // Verifica se o usuário existe
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario) {
                // Verifica a senha
                if ($senha === $usuario['senha']) {
                    echo "Login bem-sucedido!";
                } else {
                    echo "Senha incorreta!";
                }
            } else {
                echo "Usuário não encontrado!";
                // Se o usuário não for encontrado, redireciona para a página de cadastro
                // header("Location: cadastro.php"); exit;
            }
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
                <label for="user" class="block text-gray-700">Logue com seu usuário (@):</label>
                <input type="text" id="user" name="user" required class="form-input mt-1 block w-full">
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