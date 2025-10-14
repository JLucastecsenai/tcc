<?php include "../validar.php"; ?>
<!DOCTYPE html>
<html lang="PT-br">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin - restrito</title>
    <link rel="stylesheet" href="admin_homepage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>
<style>
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: white;
    }
    p{
        font-size: 20px;
    }
    div{
        text-align: center;
        padding-top: 30px;
        padding-bottom: 30px;
    }
    .botao-acesso {
        margin-left: 60px;
        margin-right: 60px;
        font-size: 25px;
    }

    h2 {
        color: white;
    }

    .link-acesso {
        display: inline-block;
        height: 50px;
        width: 450px;
        font-size: 25px;
        padding: 0.5rem 2rem;
        background-color: #0d6efd;
        color: white;
        text-decoration: none;
        border-radius: 0.375rem;
        border: 1px solid #0d6efd;
        transition: all 0.3s ease;
    }

    .link-acesso:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        color: white;
    }
</style>

<body>
    <header>
        <div class="cabecalho">
            <div class="logo">
                <img src="../imgs/logo site.png" alt="logo do site">
                <button type="submit" onclick="Deslogar()" class="btn btn-danger">SAIR</button>
            </div>
        </div>
    </header>
    <main>
        <div class="MENSAGENS">
            <h2>MENSAGENS</h2>
            <p>Ao clicar no link você será redirecionado a uma página onde terão todas as mensagens de nossos possíveis clientes</p>
            <div class="botao-acesso">
                <a href="../restrito/pastas_admin/MENSAGENS.php" class="link-acesso">ACESSAR</a>
            </div>
        </div>
        <div class="CLIENTES">
            <h2>CLIENTES</h2>
            <p>Ao clicar no link você será redirecionado à página onde terão todos os clientes cadastrados</p>
            <div class="botao-acesso">
                <a href="../restrito/pastas_admin/CLIENTES.php" class="link-acesso">ACESSAR</a>
            </div>
        </div>
        <div class="DEMANDAS">
            <h2>DEMANDAS</h2>
            <p>Ao clicar no link você será redirecionado à página onde terão as demandas a serem atendidas</p>
            <div class="botao-acesso">
                <a href="../restrito/pastas_admin/DEMANDAS.php" class="link-acesso">ACESSAR</a>
            </div>

        </div>
        <div class="FUNCIONARIOS">
            <h2>FUNCIONARIOS</h2>
            <p>Ao clicar no link você será redirecionado à página onde terão todos os funcionários cadastrados</p>
            <div class="botao-acesso">
                <a href="../restrito/pastas_admin/FUNCIONARIOS.php" class="link-acesso">ACESSAR</a>
            </div>
        </div>
    </main>
</body>
<script>
    function Deslogar() {
        window.location.href = "../logout.php";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>