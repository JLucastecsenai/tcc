<?php
require_once "conexao.php";

// PROTEÇÃO: Esta linha garante que apenas usuários logados acessem esta página
requerLogin();

// Opcional: Verificar se é admin
// if (!isAdmin()) {
//     redirecionarCom('admin_homepage.php', 'Você não tem permissão para acessar esta página!', 'danger');
// }

// Obtém dados do usuário logado
$usuario = getDadosUsuario();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Protegida - NeoHome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin_homepage.php">
            <i class="bi bi-house-door-fill me-2"></i>NeoHome
        </a>
        <div class="ms-auto">
            <span class="navbar-text text-white me-3">
                <i class="bi bi-person-circle me-1"></i>
                <?php echo htmlspecialchars($usuario['login']); ?>
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i>Sair
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php exibirMensagemSessao(); ?>
    
    <h1>Página Protegida</h1>
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        Você está autenticado como: <strong><?php echo htmlspecialchars($usuario['login']); ?></strong>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Informações do Usuário</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>ID:</strong> <?php echo $usuario['id']; ?></li>
                <li class="list-group-item"><strong>Login:</strong> <?php echo htmlspecialchars($usuario['login']); ?></li>
                <li class="list-group-item"><strong>Tipo:</strong> 
                    <?php echo isAdmin() ? '<span class="badge bg-danger">Administrador</span>' : '<span class="badge bg-secondary">Usuário</span>'; ?>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="admin_homepage.php" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Voltar ao Painel
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>