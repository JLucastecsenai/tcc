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

    .botao-clicar{
        height: 50px;
        font-size: 25px;
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
            <p>Ao clicar no botão você sera redirecionadoo a uma pagina onde teram todas as mensagens de nossos possiveis clientes</p>
            <div class="d-grid gap-2 botao-acesso">
                <button type="button" class="btn btn-primary botao-clicar" onclick="RedirecionarParaMensagens()">ACESSAR</button>
            </div>
        </div>
        <div class="CLIENTES">
            <h2>CLIENTES</h2>
            <p>Ao clicar no botão você sera redirecionado à página onde teram todos os clientes cadastrados</p>
            <div class="d-grid gap-2 botao-acesso ">
                <button type="button" class="btn btn-primary botao-clicar" onclick="RedirecionarParaClientes()">ACESSAR</button>
            </div>
        </div>
        <div class="DEMANDAS">
            <h2>DEMANDAS</h2>
            <p>Ao clicar no botão você sera redirecionado à página onde teram as demandas a serem atendidas</p>
            <div class="d-grid gap-2 botao-acesso ">
                <button type="button" class="btn btn-primary botao-clicar" onclick="RedirecionarParaDemandas()">ACESSAR</button>
            </div>

        </div>
        <div class="FUNCIONARIOS">
            <h2>FUNCIONARIOS</h2>
            <p>Ao clicar no botão você sera redirecionado à página onde teram todos os funcionários cadastrados</p>
            <div class="d-grid gap-2 botao-acesso ">
                <button type="button" class="btn btn-primary botao-clicar" onclick="RedirecionarParaFuncionarios()">ACESSAR</button>
            </div>
    </main>
</body>
<script>
    function RedirecionarParaMensagens() {
        window.location.href = "../restrito/pastas_admin/MENSAGENS.php";
    }

    function RedirecionarParaClientes() {
        window.location.href = "../restrito/pastas_admin/CLIENTES.php";
    }

    function RedirecionarParaDemandas() {
        window.location.href = "../restrito/pastas_admin/DEMANDAS.php";
    }

    function RedirecionarParaFuncionarios() {
        window.location.href = "../restrito/pastas_admin/FUNCIONARIOS.php";
    }

    function Deslogar() {
        window.location.href = "../logout.php";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>