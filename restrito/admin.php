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
    <style>
        body {
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            padding-left: 2.5rem;
        }
        .input-group-text {
            background: none;
            border-right: none;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
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
                <input type="password" class="form-control" name="senha" placeholder="Digite sua senha" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Acessar</button>
    </form>

    <?php
        if (isset($_POST['login'])) {
            $login = $_POST['login'];
            $senha = hash('sha512', $_POST['senha']);

            include "conexao.php";
            $sql = "SELECT * FROM `usuarios` WHERE login = '$login' AND senha = '$senha'";

            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) == 1) {
                session_start();
                $_SESSION['login'] = $login;
                header("location: restrito");
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