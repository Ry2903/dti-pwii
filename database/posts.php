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
        $user = $_POST['user'];
        $conteudo = $_POST['conteudo'];
        
        // Inicializa o caminho da imagem
        $imagemPath = null;

        // Verifica se a imagem foi enviada e se não há erro
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            // Define o diretório para salvar a imagem
            $uploadDir = 'uploads/';
            
            // Cria o diretório, caso não exista
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Renomeia o arquivo com o nome do usuário e o nome original
            $imagemName = $user . '_post_' . basename($_FILES['imagem']['name']);
            $imagemPath = $uploadDir . $imagemName;

            // Move a imagem para o diretório
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
                echo "Imagem enviada com sucesso!<br>";
            } else {
                echo "Erro ao enviar a imagem.<br>";
            }
        }

        // Inserir o post na tabela 'posts', incluindo o caminho da imagem
        $sql = "INSERT INTO posts (user, conteudo, imagem) VALUES (:user, :conteudo, :imagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt->bindValue(':conteudo', $conteudo, PDO::PARAM_STR);
        $stmt->bindValue(':imagem', $imagemPath, PDO::PARAM_STR);
        $stmt->execute();

        echo "Post publicado com sucesso!";
    }

    // Consultar todos os posts
    $sql = "SELECT codpost, user, conteudo, imagem, data_postagem FROM posts ORDER BY data_postagem DESC";
    $stmt = $pdo->query($sql);  // Executa a consulta
    
    // Obtém todos os resultados como um array associativo
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    // Em caso de erro, exibe a mensagem de erro
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Post - Fashion Mavens</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4">Criar Novo Post</h2>
        <form method="POST" enctype="multipart/form-data" class="max-w-lg">
            <div class="mb-4">
                <label for="user" class="block text-gray-700">@ do Usuário:</label>
                <input type="text" id="user" name="user" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="conteudo" class="block text-gray-700">Conteúdo:</label>
                <textarea id="conteudo" name="conteudo" required class="form-input mt-1 block w-full" rows="4"></textarea>
            </div>

            <div class="mb-4">
                <label for="imagem" class="block text-gray-700">Imagem do Post:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" class="form-input mt-1 block w-full">
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Publicar</button>
        </form>

        <hr class="my-8">

        <h2 class="text-2xl font-bold mb-4">Últimos Posts</h2>
        
        <!-- Verifica se há posts -->
        <?php if (count($result) > 0): ?>
            <div>
                <?php foreach ($result as $row): ?>
                    <div class="border p-4 mb-4 rounded-lg bg-white shadow">
                        <p class="text-gray-600 font-semibold">@<?php echo htmlspecialchars($row['user']); ?> - <span class="text-sm text-gray-500"><?php echo $row['data_postagem']; ?></span></p>
                        <p><?php echo htmlspecialchars($row['conteudo']); ?></p>
                        
                        <?php if ($row['imagem']): ?>
                            <div class="mt-4">
                                <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem do post" class="w-full h-auto rounded-lg">
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum post encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
