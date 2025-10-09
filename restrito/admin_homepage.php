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

<body>
    <header>
        <div class="cabecalho">
            <div class="logo">
                <img src="../imgs/logo site.png" alt="logo do site">
                <button type="submit" onclick="RedirecionarParaMensagens()"  class="btn btn-danger">SAIR</button>
            </div>
        </div>
    </header>
    <main>
        <div class="MENSAGENS">
            <h2>MENSAGENS</h2>
            <p>Ao clicar no botão você sera recirecionado a uma pagina onde teram todas as mensagens de nossos clientes</p>
            <button type="submit" onclick="RedirecionarParaMensagens()" class="btn btn-primary botao-mensagens">SAIR</button>
        </div>
        <div class="CLIENTES">
            <h2>CLIENTES</h2>
        </div>
        <div class="DEMANDAS">

        </div>
        <div class="FUNCIONARIOS">

        </div>
        <div class="LOGOUT">

        </div>

    </main>
    <footer>

    </footer>
</body>
<script>
    function RedirecionarParaMensagens(){
        window.location.href = "../logout.php";
    }
    function RedirecionarParaClientes(){
        window.location.href = "../index.php";
    }
    function RedirecionarParaDemandas(){
        window.location.href = "../index.php";
    }
    function RedirecionarParaFuncionarios(){
        window.location.href = "../index.php";
    }
    function Deslogar(){
        window.location.href = "../logout.php";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>