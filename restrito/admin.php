<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin - NeoHome</title>
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Ícones do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="login-container">
    <h2 class="text-center">Login</h2>
    <form action="admin_homepage.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" name="login" placeholder="Digite seu usuário" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" name="senha_admin" placeholder="Digite sua senha" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Acessar</button>
    </form>

    <?php
        if (isset($_POST['admin_login'])) {
            $login = $_POST['login'];
            $senha_admin = hash('sha512', $_POST['senha_admin']);

            include "conexao.php";
            $sql = "SELECT * FROM `admin_login` WHERE login = '$login' AND senha = '$senha_admin'";

            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) == 1) {
                session_start();
                $_SESSION['login'] = $login;
                header("location: restrito/admin_homepage.php");
            } else {
                echo "<div class='alert alert-danger mt-3 text-center'>Usuário ou senha inválidos!</div>";
            }
        }
    ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>