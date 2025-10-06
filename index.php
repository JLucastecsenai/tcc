<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Neo Home</title>
</head>

<body>
  <header>
    <div class="cabecalho">
      <div class="logo">
        <img src="imgs/logo site.png" alt="logo do site">
      </div>
      <div class="links-do-site">
        <a href="#quem-somos">QUEM SOMOS</a>
        <a href="#produtos">NOSSOS PRODUTOS</a>
        <a href="#orcamento">FAÇA UM ORÇAMENTO</a>
        <a href="#contato">CONTATOS</a>
      </div>
    </div>
  </header>
  <main>
    <div class="quem-somos" id="quem-somos">
      <h1>QUEM SOMOS</h1>
    </div>
    <div class="produtos" id="produtos">
      <h1>PRODUTOS</h1>
    </div>
    <div class="orcamento" id="orcamento">
      <h1>ORÇAMENTO</h1>
    </div>
    <div class="contato" id="contato">
      <h1 class="titulo-contatos">CONTATO</h1>
      <div class="formulario-contato">
        <form method="POST" id="Formulario">
          <div class="campo-formulario">
            <label for="nome">Nome completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo">
          </div>

          <div class="campo-formulario">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="seu@email.com">
          </div>

          <div class="campo-formulario">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required placeholder="(11) 99999-9999">
          </div>

          <div class="campo-formulario">
            <label for="mensagem">Descreva o que você deseja:</label>
            <textarea id="mensagem" name="mensagem" placeholder="Descreva em detalhes o que você precisa..."></textarea>
          </div>

          <button type="submit" class="btn-enviar">Enviar Mensagem</button>
        </form>
      </div>
    </div>
  </main>
  <footer>
    <div>
      <div>
        <img class="logo-footer" src="imgs/logo site.png" alt="logo">
      </div>
      <div class="redes-footer">
        <a href=""><img class="img-rede" src="imgs/facebook.png" alt="facebook"></a>
        <a href=""><img class="img-rede" src="imgs/instagram.png" alt="instagram"></a>
        <a href=""><img class="img-rede" src="imgs/linkedin.png" alt="linkedin"></a>
        <a href=""><img class="img-rede" src="imgs/whatsapp.png" alt="whatsapp"></a>
      </div>
      <div class="funcionario">
        <h3>Já é nosso funcionario?:<a href="admin.html"><b>clique aqui</b></a></h3>
      </div>
      <div class="marca-registrada">
        <h3>contate-nos: <a href="mailto:contato@neohome.com.br?subject=Gostaria de fazer um orçmento"
            target="_blank"><b>contato@neohome.com.br</b></a></h3>
        <h3>®NEO HOME systens, 2025</h3>
      </div>
    </div>
    <div class="endereço">
      <div class="texto-ende">
        <h4>endereço</h4>
        <p>R. Paquetá, 45 - Vila Ipanema, Ipatinga - MG, 35160-061</p>
      </div>
      <div>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d940.7407212151111!2d-42.5132917!3d-19.4848949!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb0006045ebc9b9%3A0x3a850af7145a7901!2sR.%20Paquet%C3%A1%2C%2045%20-%20Vila%20Ipanema%2C%20Ipatinga%20-%20MG%2C%2035160-061!5e0!3m2!1spt-BR!2sbr!4v1759141859089!5m2!1spt-BR!2sbr"
          width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </footer>
  <?php 
          include "restrito/conexao.php";
          
          $nome = $_POST['nome'];
          $email = $_POST['email'];
          $telefone = $_POST['telefone'];
          $mensagem = $_POST['msg'];

          $sql = "INSERT INTO `mensagem` ( `nome`, `telefone`, `email`, `msg`) 
                  VALUES ('$nome','$telefone','$email','$mensagem')";

          if (mysqli_query($conn, $sql)) {
            mensagem("$nome cadastrado com sucesso!",'success');
          } else
            mensagem("$nome NÃO cadastrado!",'danger');
         ?> 
</body>

</html>