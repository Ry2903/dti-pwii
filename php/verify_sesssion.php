<?php
session_start();

if (isset($_SESSION['uer'])) {
    // Retorna o nome do usuário em JSON
    echo json_encode(['user' => $_SESSION['user']]);
    http_response_code(200); // Código de sucesso
} else {
    http_response_code(401); // Código de não autorizado
}
?>