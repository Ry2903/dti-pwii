<?php
session_start();

if (isset($_SESSION['user'])) {
    // A sessão está ativa, usuário está logado
    header('location: home.html');
} else {
    // A sessão não está ativa, redirecionar para login
    header('Location: cadastro.html');
    exit;
}
?>