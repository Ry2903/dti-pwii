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
            $user = trim($_POST['user']); //evita espaços em branccos
            $nome = trim($_POST['nome']);
            $nasc = trim($_POST['nasc']);
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);

            // Verificação 1: idade
            //Se o usuário for menor de 13 anos, barra o cadastro
            function validarIdade($dataNascimento) {
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
            
            // Verificação para evitar cadastros duplicados
            $sql = "SELECT COUNT(*) FROM cadastro WHERE user = :user OR email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user', $user, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            // Verifica se o user ou o e-mail já existem
            if ($result > 0) {
                echo json_encode([
                    'status' => 'erro',
                    'mensagem' => 'Este nome de usuário ou e-mail já está cadastrado!'
                ]);
                exit;
            }

            // Prepara a consulta SQL para inserção
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
            
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Cadastro realizado com sucesso!'
            ]);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()
        ]);
    }
?>
