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
    
    // Diretório onde as imagens serão salvas
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Cria o diretório, caso não exista
    }

    // Verifica se o formulário foi submetido
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtém os dados do formulário
        $user = $_POST['user'];
        $bio = $_POST['bio'];
        
        // Inicializa os caminhos das imagens
        $bannerPath = '';
        $pfpPath = '';

        // Verifica se o banner foi enviado e se não há erro
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === 0) {
            // Renomeia o arquivo do banner com o nome do usuário (@user_banner)
            $bannerName = $user . '_banner_' . basename($_FILES['banner']['name']);
            $bannerPath = $uploadDir . $bannerName;
            if (move_uploaded_file($_FILES['banner']['tmp_name'], $bannerPath)) {
                echo "Banner enviado com sucesso!<br>";
            } else {
                echo "Erro ao enviar o banner.<br>";
            }
        } else {
            echo "Erro no upload do banner: " . (isset($_FILES['banner']['error']) ? $_FILES['banner']['error'] : 'Arquivo não enviado') . "<br>";
        }
        
        // Verifica se a foto de perfil foi enviada e se não há erro
        if (isset($_FILES['pfp']) && $_FILES['pfp']['error'] === 0) {
            // Renomeia o arquivo da foto de perfil com o nome do usuário (@user_pfp)
            $pfpName = $user . '_pfp_' . basename($_FILES['pfp']['name']);
            $pfpPath = $uploadDir . $pfpName;
            if (move_uploaded_file($_FILES['pfp']['tmp_name'], $pfpPath)) {
                echo "Foto de perfil enviada com sucesso!<br>";
            } else {
                echo "Erro ao enviar a foto de perfil.<br>";
            }
        } else {
            echo "Erro no upload da foto de perfil: " . (isset($_FILES['pfp']['error']) ? $_FILES['pfp']['error'] : 'Arquivo não enviado') . "<br>";
        }
        
        // Verifica se o usuário já existe na tabela 'userpage'
        $sql = "SELECT * FROM userpage WHERE user = :user";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt->execute();

        // Se o usuário já existe, faz um UPDATE
        if ($stmt->rowCount() > 0) {
            // Atualiza os dados do usuário
            $sqlUpdate = "UPDATE userpage SET bio = :bio, banner = :banner, pfp = :pfp WHERE user = :user";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindValue(':bio', $bio, PDO::PARAM_STR);
            $stmtUpdate->bindValue(':banner', $bannerPath, PDO::PARAM_STR);
            $stmtUpdate->bindValue(':pfp', $pfpPath, PDO::PARAM_STR);
            $stmtUpdate->bindValue(':user', $user, PDO::PARAM_STR);
            $stmtUpdate->execute();
            
            echo "Dados atualizados com sucesso!";
        } else {
            // Caso o usuário não exista, insere um novo registro
            $sqlInsert = "INSERT INTO userpage (user, bio, banner, pfp) 
                          VALUES (:user, :bio, :banner, :pfp)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindValue(':user', $user, PDO::PARAM_STR);
            $stmtInsert->bindValue(':bio', $bio, PDO::PARAM_STR);
            $stmtInsert->bindValue(':banner', $bannerPath, PDO::PARAM_STR);
            $stmtInsert->bindValue(':pfp', $pfpPath, PDO::PARAM_STR);
            $stmtInsert->execute();
            
            echo "Dados inseridos com sucesso!";
        }
    }
} catch (PDOException $e) {
    // Em caso de erro, exibe a mensagem de erro
    echo "Erro: " . $e->getMessage();   
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>  
    <title>Fashion Maven's - Profile</title>
    <link 
    href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" 
    rel="stylesheet"
    >
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4">Página do usuário:</h2>
        <form method="POST" enctype="multipart/form-data" class="max-w-lg">
            <div class="mb-4">
                <label for="user" class="block text-gray-700">@ do Usuário:</label>
                <input type="text" id="user" name="user" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="bio" class="block text-gray-700">Bio:</label>
                <input type="text" id="bio" name="bio" required class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="banner" class="block text-gray-700">Banner:</label>
                <input type="file" id="banner" name="banner" accept="image/*" class="form-input mt-1 block w-full">
            </div>
            
            <div class="mb-4">
                <label for="pfp" class="block text-gray-700">Foto de Perfil:</label>
                <input type="file" id="pfp" name="pfp" accept="image/*" class="form-input mt-1 block w-full">
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enviar</button>
        </form>
    </div>
</body>
</html>