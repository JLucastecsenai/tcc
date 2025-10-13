<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Neo Home - Automação Residencial Inteligente</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary: #0c0a33;
      --primary-light: #1a1760;
      --accent: #00d4ff;
      --text-dark: #1a1a1a;
      --text-light: #ffffff;
      --gray: #6b6a6a;
      --light-bg: #f8f9fa;
    }

    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    /* Header */
    header {
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      background: rgba(12, 10, 51, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .cabecalho {
      max-width: 1400px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .logo img {
      width: 200px;
      height: auto;
    }

    .links-do-site {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    .links-do-site a {
      text-decoration: none;
      color: var(--text-light);
      font-weight: 500;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .links-do-site a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--accent);
      transition: width 0.3s ease;
    }

    .links-do-site a:hover::after {
      width: 100%;
    }

    .menu-toggle {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
    }

    .menu-toggle span {
      width: 25px;
      height: 3px;
      background: white;
      transition: all 0.3s ease;
    }

    /* Hero Section */
    .hero {
      margin-top: 80px;
      height: 90vh;
      background: linear-gradient(135deg, #0c0a33 0%, #1a1760 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
      border-radius: 50%;
      top: -200px;
      right: -200px;
      animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(30px); }
    }

    .hero-content {
      max-width: 1200px;
      padding: 0 2rem;
      text-align: center;
      color: white;
      z-index: 1;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .hero .highlight {
      color: var(--accent);
    }

    .hero p {
      font-size: 1.3rem;
      margin-bottom: 2.5rem;
      opacity: 0.9;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .cta-button {
      display: inline-block;
      padding: 1rem 2.5rem;
      background: var(--accent);
      color: var(--primary);
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
    }

    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(0, 212, 255, 0.4);
    }

    /* Quem Somos */
    .quem-somos {
      padding: 6rem 2rem;
      background: var(--light-bg);
    }

    .quem-somos-content {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
    }

    .quem-somos h2 {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 1.5rem;
    }

    .quem-somos p {
      font-size: 1.1rem;
      line-height: 1.8;
      color: var(--text-dark);
      margin-bottom: 1rem;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
      margin-top: 2rem;
    }

    .stat-item {
      text-align: center;
      padding: 1.5rem;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .stat-item h3 {
      font-size: 2.5rem;
      color: var(--accent);
      margin-bottom: 0.5rem;
    }

    .stat-item p {
      font-size: 0.9rem;
      color: var(--gray);
    }

    /* Produtos */
    .produtos {
      padding: 6rem 2rem;
      background: white;
    }

    .produtos-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .produtos h2 {
      text-align: center;
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 3rem;
    }

    .produtos-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .produto-card {
      background: var(--light-bg);
      border-radius: 20px;
      padding: 2.5rem;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .produto-card:hover {
      transform: translateY(-10px);
      border-color: var(--accent);
      box-shadow: 0 20px 40px rgba(0, 212, 255, 0.1);
    }

    .produto-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, var(--accent), var(--primary));
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    .produto-card h3 {
      font-size: 1.5rem;
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .produto-card p {
      color: var(--gray);
      line-height: 1.6;
    }

    .produto-card ul {
      list-style: none;
      margin-top: 1rem;
    }

    .produto-card ul li {
      padding: 0.5rem 0;
      color: var(--text-dark);
      position: relative;
      padding-left: 1.5rem;
    }

    .produto-card ul li::before {
      content: '✓';
      position: absolute;
      left: 0;
      color: var(--accent);
      font-weight: bold;
    }

    /* Orçamento/Contato */
    .contato {
      padding: 6rem 2rem;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      color: white;
    }

    .contato-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .contato h2 {
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .contato-subtitle {
      text-align: center;
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 3rem;
    }

    .formulario-contato {
      max-width: 800px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 3rem;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .campo-formulario {
      margin-bottom: 1.5rem;
    }

    .campo-formulario label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      font-size: 1rem;
    }

    .campo-formulario input,
    .campo-formulario textarea {
      width: 100%;
      padding: 1rem;
      border: 2px solid rgba(255, 255, 255, 0.2);
      border-radius: 10px;
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.95);
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    .campo-formulario input:focus,
    .campo-formulario textarea:focus {
      outline: none;
      border-color: var(--accent);
      background: white;
    }

    .campo-formulario textarea {
      min-height: 150px;
      resize: vertical;
    }

    .btn-enviar {
      width: 100%;
      padding: 1.2rem;
      background: var(--accent);
      color: var(--primary);
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 1rem;
    }

    .btn-enviar:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
    }

    .btn-enviar:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    /* Footer */
    footer {
      background: #050419;
      color: white;
      padding: 4rem 2rem 2rem;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 3rem;
      margin-bottom: 2rem;
    }

    .footer-section h3 {
      margin-bottom: 1.5rem;
      font-size: 1.3rem;
    }

    .footer-section p,
    .footer-section a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      line-height: 1.8;
      display: block;
      transition: color 0.3s ease;
    }

    .footer-section a:hover {
      color: var(--accent);
    }

    .redes-sociais {
      display: flex;
      gap: 1rem;
      margin-top: 1rem;
    }

    .rede-social {
      transition: all 0.3s ease;
      display: inline-block;
    }

    .rede-social:hover {
      transform: translateY(-3px);
      opacity: 0.7;
    }

    .rede-social img {
      width: 40px;
      height: 40px;
      object-fit: contain;
    }

    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      text-align: center;
      color: rgba(255, 255, 255, 0.5);
    }

    .mapa-container {
      margin-top: 1rem;
      border-radius: 15px;
      overflow: hidden;
    }

    .mapa-container iframe {
      width: 100%;
      height: 250px;
      border: none;
    }

    /* Responsivo */
    @media (max-width: 968px) {
      .links-do-site {
        position: fixed;
        top: 70px;
        left: -100%;
        width: 100%;
        height: calc(100vh - 70px);
        background: rgba(12, 10, 51, 0.98);
        flex-direction: column;
        justify-content: center;
        transition: left 0.3s ease;
        padding: 2rem;
      }

      .links-do-site.active {
        left: 0;
      }

      .links-do-site a {
        font-size: 1.3rem;
        padding: 1rem;
      }

      .menu-toggle {
        display: flex;
      }

      .cabecalho {
        padding: 1rem;
      }

      .logo img {
        width: 150px;
      }

      .hero {
        margin-top: 70px;
        height: auto;
        min-height: 70vh;
        padding: 3rem 1rem;
      }

      .hero h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
      }

      .hero p {
        font-size: 1rem;
        margin-bottom: 2rem;
      }

      .cta-button {
        padding: 0.9rem 2rem;
        font-size: 1rem;
      }

      .quem-somos {
        padding: 4rem 1.5rem;
      }

      .quem-somos-content {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .quem-somos h2 {
        font-size: 2rem;
      }

      .quem-somos p {
        font-size: 1rem;
      }

      .stats {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .stat-item {
        padding: 1rem;
      }

      .stat-item h3 {
        font-size: 2rem;
      }

      .produtos {
        padding: 4rem 1.5rem;
      }

      .produtos h2 {
        font-size: 2rem;
      }

      .produtos-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .produto-card {
        padding: 2rem;
      }

      .produto-card h3 {
        font-size: 1.3rem;
      }

      .contato {
        padding: 4rem 1.5rem;
      }

      .contato h2 {
        font-size: 2rem;
      }

      .contato-subtitle {
        font-size: 1rem;
      }

      .formulario-contato {
        padding: 2rem 1.5rem;
      }

      .campo-formulario input,
      .campo-formulario textarea {
        padding: 0.9rem;
        font-size: 0.95rem;
      }

      .btn-enviar {
        padding: 1rem;
        font-size: 1rem;
      }

      footer {
        padding: 3rem 1.5rem 2rem;
      }

      .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
      }

      .footer-section h3 {
        font-size: 1.2rem;
        margin-bottom: 1rem;
      }

      .redes-sociais {
        justify-content: center;
      }

      .mapa-container iframe {
        height: 200px;
      }
    }

    /* Tablets */
    @media (min-width: 769px) and (max-width: 968px) {
      .produtos-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .footer-content {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    /* Smartphones pequenos */
    @media (max-width: 480px) {
      .cabecalho {
        padding: 0.8rem;
      }

      .logo img {
        width: 120px;
      }

      .hero {
        margin-top: 60px;
        padding: 2rem 1rem;
      }

      .hero h1 {
        font-size: 1.6rem;
      }

      .hero p {
        font-size: 0.95rem;
      }

      .cta-button {
        padding: 0.8rem 1.5rem;
        font-size: 0.95rem;
      }

      .quem-somos,
      .produtos,
      .contato {
        padding: 3rem 1rem;
      }

      .quem-somos h2,
      .produtos h2,
      .contato h2 {
        font-size: 1.7rem;
        margin-bottom: 1.5rem;
      }

      .formulario-contato {
        padding: 1.5rem 1rem;
      }

      .campo-formulario {
        margin-bottom: 1.2rem;
      }

      .campo-formulario label {
        font-size: 0.95rem;
        margin-bottom: 0.4rem;
      }

      .campo-formulario input,
      .campo-formulario textarea {
        padding: 0.8rem;
        font-size: 0.9rem;
      }

      .campo-formulario textarea {
        min-height: 120px;
      }

      .btn-enviar {
        padding: 0.9rem;
        font-size: 0.95rem;
      }

      .produto-card {
        padding: 1.5rem;
      }

      .produto-icon {
        width: 60px;
        height: 60px;
        font-size: 1.8rem;
      }

      .produto-card h3 {
        font-size: 1.2rem;
      }

      .produto-card p,
      .produto-card ul li {
        font-size: 0.95rem;
      }

      footer {
        padding: 2rem 1rem 1.5rem;
      }

      .footer-section {
        text-align: center;
      }

      .footer-section h3 {
        font-size: 1.1rem;
      }

      .footer-section p,
      .footer-section a {
        font-size: 0.9rem;
      }

      .rede-social img {
        width: 35px;
        height: 35px;
      }

      .mapa-container iframe {
        height: 180px;
      }

      .stat-item h3 {
        font-size: 1.8rem;
      }

      .stat-item p {
        font-size: 0.85rem;
      }
    }

    /* Landscape em smartphones */
    @media (max-height: 500px) and (orientation: landscape) {
      .hero {
        height: auto;
        min-height: 100vh;
        padding: 4rem 1rem;
      }

      .links-do-site {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 1rem;
        height: auto;
        padding: 2rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="cabecalho">
      <div class="logo">
        <img src="imgs/logo site.png" alt="Neo Home Logo">
      </div>
      <nav class="links-do-site" id="menu">
        <a href="#quem-somos">QUEM SOMOS</a>
        <a href="#produtos">PRODUTOS</a>
        <a href="#orcamento">ORÇAMENTO</a>
        <a href="#contato">CONTATO</a>
      </nav>
      <div class="menu-toggle" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </header>

  <section class="hero">
    <div class="hero-content">
      <h1>Transforme sua casa em um <span class="highlight">lar inteligente</span></h1>
      <p>Automação residencial completa com Alexa, Google Home, segurança avançada e muito mais. O futuro mora aqui.</p>
      <a href="#orcamento" class="cta-button">Faça seu orçamento</a>
    </div>
  </section>

  <section class="quem-somos" id="quem-somos">
    <div class="quem-somos-content">
      <div>
        <h2>Quem Somos</h2>
        <p>A <strong>Neo Home</strong> é especialista em automação residencial inteligente, trazendo tecnologia de ponta para o seu lar.</p>
        <p>Oferecemos soluções completas e personalizadas que transformam ambientes convencionais em espaços modernos, seguros e eficientes.</p>
        <p>Nossa equipe especializada trabalha com as melhores marcas e tecnologias do mercado, garantindo qualidade, segurança e a melhor experiência em automação residencial.</p>
      </div>
      <div class="stats">
        <div class="stat-item">
          <h3>500+</h3>
          <p>Projetos Realizados</p>
        </div>
        <div class="stat-item">
          <h3>98%</h3>
          <p>Clientes Satisfeitos</p>
        </div>
        <div class="stat-item">
          <h3>10+</h3>
          <p>Anos de Experiência</p>
        </div>
      </div>
    </div>
  </section>

  <section class="produtos" id="produtos">
    <div class="produtos-container">
      <h2>Nossos Produtos e Serviços</h2>
      <div class="produtos-grid">
        <div class="produto-card">
          <div class="produto-icon">🎙️</div>
          <h3>Assistentes de Voz</h3>
          <p>Controle total por comando de voz</p>
          <ul>
            <li>Integração com Alexa</li>
            <li>Compatível com Google Home</li>
            <li>Automação por voz</li>
            <li>Rotinas personalizadas</li>
          </ul>
        </div>

        <div class="produto-card">
          <div class="produto-icon">🔒</div>
          <h3>Segurança Inteligente</h3>
          <p>Proteja sua família com tecnologia</p>
          <ul>
            <li>Câmeras IP Full HD</li>
            <li>Fechaduras eletrônicas</li>
            <li>Sensores de movimento</li>
            <li>Monitoramento remoto</li>
          </ul>
        </div>

        <div class="produto-card">
          <div class="produto-icon">🪟</div>
          <h3>Controle de Ambientes</h3>
          <p>Conforto e praticidade</p>
          <ul>
            <li>Cortinas automáticas</li>
            <li>Janelas inteligentes</li>
            <li>Persianas motorizadas</li>
            <li>Controle de iluminação</li>
          </ul>
        </div>

        <div class="produto-card">
          <div class="produto-icon">🔊</div>
          <h3>Sistema de Áudio</h3>
          <p>Som ambiente para toda a casa</p>
          <ul>
            <li>Áudio multiroom</li>
            <li>Streaming integrado</li>
            <li>Qualidade premium</li>
            <li>Controle por zonas</li>
          </ul>
        </div>

        <div class="produto-card">
          <div class="produto-icon">🌡️</div>
          <h3>Climatização</h3>
          <p>Temperatura perfeita sempre</p>
          <ul>
            <li>Termostatos inteligentes</li>
            <li>Ar condicionado smart</li>
            <li>Programação automática</li>
            <li>Economia de energia</li>
          </ul>
        </div>

        <div class="produto-card">
          <div class="produto-icon">💡</div>
          <h3>Iluminação Smart</h3>
          <p>Luz ideal para cada momento</p>
          <ul>
            <li>Lâmpadas inteligentes</li>
            <li>Controle de intensidade</li>
            <li>Mudança de cores</li>
            <li>Cenas personalizadas</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="contato" id="orcamento">
    <div class="contato-container">
      <h2>Faça um Orçamento</h2>
      <p class="contato-subtitle">Preencha o formulário e nossa equipe entrará em contato</p>
      
      <div class="formulario-contato">
        <form action="cadastro_script.php" method="POST" id="Formulario">
          <div class="campo-formulario">
            <label for="nome">Nome completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" maxlength="100" required>
          </div>

          <div class="campo-formulario">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="seu@email.com" maxlength="100" required>
          </div>

          <div class="campo-formulario">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="(11) 99999-9999" maxlength="11" pattern="[0-9]{10,11}" required>
          </div>

          <div class="campo-formulario">
            <label for="msg">Descreva o que você deseja:</label>
            <textarea id="msg" name="msg" placeholder="Descreva em detalhes o que você precisa..." maxlength="500" rows="5" required></textarea>
          </div>

          <button type="submit" class="btn-enviar">Enviar Mensagem</button>
        </form>
      </div>
    </div>
  </section>

  <footer id="contato">
    <div class="footer-content">
      <div class="footer-section">
        <img src="imgs/logo site.png" alt="Neo Home" style="width: 180px; margin-bottom: 1rem;">
        <p>Transformando casas em lares inteligentes desde 2015.</p>
        <div class="redes-sociais">
          <a href="#" class="rede-social">
            <img src="imgs/facebook.png" alt="Facebook">
          </a>
          <a href="#" class="rede-social">
            <img src="imgs/instagram.png" alt="Instagram">
          </a>
          <a href="#" class="rede-social">
            <img src="imgs/linkedin.png" alt="LinkedIn">
          </a>
          <a href="#" class="rede-social">
            <img src="imgs/whatsapp.png" alt="WhatsApp">
          </a>
        </div>
      </div>

      <div class="footer-section">
        <h3>Contato</h3>
        <a href="mailto:contato@neohome.com.br">contato@neohome.com.br</a>
        <a href="tel:+5531999999999">(31) 99999-9999</a>
        <p style="margin-top: 1rem;">Horário de atendimento:<br>Seg-Sex: 8h às 18h<br>Sáb: 8h às 12h</p>
      </div>

      <div class="footer-section">
        <h3>Endereço</h3>
        <p>R. Paquetá, 45<br>Vila Ipanema<br>Ipatinga - MG<br>CEP: 35160-061</p>
        <div class="mapa-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d940.7407212151111!2d-42.5132917!3d-19.4848949!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb0006045ebc9b9%3A0x3a850af7145a7901!2sR.%20Paquet%C3%A1%2C%2045%20-%20Vila%20Ipanema%2C%20Ipatinga%20-%20MG%2C%2035160-061!5e0!3m2!1spt-BR!2sbr!4v1759141859089!5m2!1spt-BR!2sbr" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>

      <div class="footer-section">
        <h3>Links Rápidos</h3>
        <a href="#quem-somos">Quem Somos</a>
        <a href="#produtos">Produtos</a>
        <a href="#orcamento">Orçamento</a>
        <a href="restrito/admin.php">Área Restrita</a>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2025 Neo Home Systems. Todos os direitos reservados.</p>
    </div>
  </footer>

  <script>
    // Menu mobile
    const menuToggle = document.getElementById('menuToggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
      menu.classList.toggle('active');
    });

    // Fechar menu ao clicar em um link
    document.querySelectorAll('.links-do-site a').forEach(link => {
      link.addEventListener('click', () => {
        menu.classList.remove('active');
      });
    });

    // Previne reenvio do formulário
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    // Controle do botão de envio
    document.getElementById('Formulario').addEventListener('submit', function() {
      const submitBtn = this.querySelector('.btn-enviar');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Enviando...';
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>
</html>