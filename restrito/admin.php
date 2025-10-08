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
        <form action="" method="POST">
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

        <br>

        <?php
        session_start();
        include('conexao.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = mysqli_real_escape_string($conn, $_POST['login']);
            $senha_digitada = $_POST['senha_admin'];

            // Criptografa a senha digitada com SHA256
            $senha_sha2 = hash('sha256', $senha_digitada);

            $sql = "SELECT * FROM admin_login WHERE login = '$login' AND senha_admin = '$senha_sha2'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $usuario = mysqli_fetch_assoc($result);

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_login'] = $usuario['login'];
                $_SESSION['funcionario_admin'] = $usuario['funcionario_admin'];
                $_SESSION['loggedin'] = true; // ← VARIÁVEL IMPORTANTE PARA O VALIDAR.PHP

                header('Location: admin_homepage.php');
                exit();
            } else {
                mensagem("Usuário ou senha incorretos!", "danger");
            }
        }
        if (isset($_GET['msg'])) {
            echo "<div class='alert alert-info'>" . htmlspecialchars($_GET['msg']) . "</div>";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>