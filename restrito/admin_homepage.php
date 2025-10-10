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
        height: 50px;
    }

    h2 {
        color: white;
    }
</style>

<body>
    <header>
        <div class="cabecalho">
            <div class="logo">
                <img src="../imgs/logo site.png" alt="logo do site">
                <button type="submit" onclick="RedirecionarParaMensagens()" class="btn btn-danger">SAIR</button>
            </div>
        </div>
    </header>
    <main>
        <div class="MENSAGENS">
            <h2>MENSAGENS</h2>
            <p>Ao clicar no botão você sera recirecionado a uma pagina onde teram todas as mensagens de nossos clientes</p>
            <div class="d-grid gap-2 botao-acesso">
                <button type="button" class="btn btn-primary" onclick="RedirecionarParaMensagens()">ACESSAR</button>
            </div>
        </div>
        <div class="CLIENTES">
            <h2>CLIENTES</h2>
            <p>Ao clicar no botão você sera recirecionado a uma pagina onde teram todos os clientes cadastrados</p>
            <div class="d-grid gap-2 botao-acesso ">
                <button type="button" class="btn btn-primary" onclick="RedirecionarParaClientes()">ACESSAR</button>
            </div>
        </div>
        <div class="DEMANDAS">
            <h2>DEMANDAS</h2>
            <p>Ao clicar no botão você sera recirecionado a uma pagina onde teram todas as mensagens de nossos clientes</p>
            <div class="d-grid gap-2 botao-acesso ">
                <button type="button" class="btn btn-primary" onclick="RedirecionarParaDemandas()">ACESSAR</button>
            </div>

        </div>
        <div class="FUNCIONARIOS">
            <h2>FUNCIONARIOS</h2>
            <p>Ao clicar no botão você sera recirecionado a uma pagina onde teram todas as mensagens de nossos clientes</p>
            <div class="d-grid gap-2 botao-acesso ">
                <button type="button" class="btn btn-primary" onclick="RedirecionarParaFuncionarios()">ACESSAR</button>
            </div>

        </div>
        <div class="LOGOUT">

        </div>

    </main>
    <footer>

    </footer>
</body>
<script>
    function RedirecionarParaMensagens() {
        window.location.href = "pastas/mensagens.php";
    }

    function RedirecionarParaClientes() {
        window.location.href = "../index.php";
    }

    function RedirecionarParaDemandas() {
        window.location.href = "../index.php";
    }

    function RedirecionarParaFuncionarios() {
        window.location.href = "../index.php";
    }

    function Deslogar() {
        window.location.href = "../logout.php";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>