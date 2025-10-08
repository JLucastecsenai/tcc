<?php
require_once 'conexao.php';

// Se já estiver logado, redireciona para homepage
if (verificarLogin()) {
    header('Location: admin_homepage.php');
    exit();
}

// Processa o login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha_admin'];
    
    if (fazerLogin($login, $senha)) {
        // Verifica se existe URL para redirecionar
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
        } else {
            header('Location: admin_homepage.php');
        }
        exit();
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - NeoHome</title>
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="login-container">
    <div class="text-center mb-4">
        <i class="bi bi-shield-lock" style="font-size: 3rem; color: #0d6efd;"></i>
        <h2 class="mt-2">Login Administrativo</h2>
        <p class="text-muted">NeoHome System</p>
    </div>
    
    <?php
    // Exibe mensagem de erro se houver
    if (isset($erro)) {
        mensagem($erro, 'danger');
    }
    
    // Exibe mensagens da sessão (ex: "Você foi desconectado")
    exibirMensagemSessao();
    ?>
    
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" name="login" placeholder="Digite seu usuário" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" name="senha_admin" placeholder="Digite sua senha" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Acessar Sistema
        </button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>