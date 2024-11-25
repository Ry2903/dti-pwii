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
            $bio = $_POST['bio'];
            $banner = $_POST['banner'];
            $pfp = $_POST['pfp'];
            
            // Prepara a consulta SQL
            $sql = "INSERT INTO userpage (user, nome, bio, banner, pfp) 
            VALUES (:user, :nome, :bio, :banner, :pfp)";
            
            // Prepara a declaração
            $stmt = $pdo->prepare($sql);
            
            // Associa os parâmetros com os valores
            $stmt->bindValue(':user', $user, PDO::PARAM_STR);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':bio', $bio, PDO::PARAM_STR);
            $stmt->bindValue(':banner', $banner, PDO::PARAM_STR);
            $stmt->bindValue(':pfp', $pfp, PDO::PARAM_STR);
            
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
                <label for="bio" class="block text-gray-700">Bio:</label>
                <input type="text" id="bio" name="bio" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="banner" class="block text-gray-700">E-mail:</label>
                <input type="image" id="banner" name="banner" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="pfp" class="block text-gray-700">Senha:</label>
                <input type="image" id="pfp" name="pfp" required class="form-input mt-1 block w-full">
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enviar</button>
        </form>
    </div>
</body>
</html>