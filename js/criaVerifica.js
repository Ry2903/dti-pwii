const createBtn = document.querySelector('.btnGnr');
const popup = document.querySelector('.popup');
const overlay = document.querySelector('.overlay');
const closeBtn = document.querySelector('.close-btn');

createBtn.addEventListener('click', () => {
    popup.style.display = 'block';
    overlay.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
    overlay.style.display = 'none';
});

overlay.addEventListener('click', () => {
    popup.style.display = 'none';
    overlay.style.display = 'none';
});
$(document).ready(function () {
    $.ajax({
        url: '/php/login_verify.php',
        method: 'POST',
        dataType: 'json',
        success: function (response) {
            // Exibe uma mensagem de boas-vindas com o nome do usuário
            Swal.fire({
                title: 'Bem-vindo!',
                text: `Olá, ${response.username}. Você está logado.`,
                icon: 'success',
                confirmButtonText: 'Continuar'
            });
        },
        error: function () {
            // Redireciona para a página de login se a sessão não for válida
            Swal.fire({
                title: 'Sessão Expirada',
                text: 'Por favor, faça login novamente.',
                icon: 'error',
                confirmButtonText: 'Ir para Login'
            }).then(() => {
                window.location.href = 'login.html';
            });
        }
    });
});