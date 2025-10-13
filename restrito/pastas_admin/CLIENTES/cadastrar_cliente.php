<?php include "../../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="cadastrar_cliente.css">
</head>
<body>
    <div class="container">
        <div class="card-header" style="background-color: #0c0a33;">Cadastrar Novo Cliente - admin</div>

        <div class="form-card">
            <form action="cadastrar_cliente_script.php" method="POST">
                <!-- Informações Pessoais -->
                <div class="form-section">
                    <h5><i class="bi bi-person-vcard"></i> Informações Pessoais</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required maxlength="128" placeholder="Digite o nome completo">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required maxlength="128" placeholder="exemplo@email.com">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                <input type="text" class="form-control" id="telefone" name="telefone" required 
                                       pattern="[0-9]{11}" placeholder="11999999999" maxlength="11">
                            </div>
                            <small class="text-muted">Apenas números (11 dígitos)</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="cpf" name="cpf" required 
                                       pattern="[0-9]{11}" placeholder="12345678900" maxlength="11">
                            </div>
                            <small class="text-muted">Apenas números (11 dígitos)</small>
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="form-section">
                    <h5><i class="bi bi-geo-alt"></i> Endereço</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cep" class="form-label">CEP *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-postcard"></i></span>
                                <input type="text" class="form-control" id="cep" name="cep" required 
                                       pattern="[0-9]{8}" placeholder="12345678" maxlength="8">
                            </div>
                            <small class="text-muted">Apenas números (8 dígitos)</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="numero_casa" class="form-label">Número</label>
                            <div class="input-group">
                                <span class="input-group-text">#</span>
                                <input type="number" class="form-control" id="numero_casa" name="numero_casa" 
                                       min="1" max="99999" placeholder="123">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control" id="complemento" name="complemento" 
                                       maxlength="30" placeholder="Apartamento, Bloco, etc.">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rodapé com Navegação -->
                <div class="btn-group">
                    <a href="../CLIENTES.PHP" class="btn btn-info" style="background-color: #0c0a33; color: #fff;">
                        <i class="bi bi-arrow-left"></i> Voltar para Lista
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg"></i> Cadastrar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Formatação dos campos numéricos
        document.getElementById('telefone').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
        
        document.getElementById('cpf').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
        
        document.getElementById('cep').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });

        // Validação em tempo real
        document.querySelector('form').addEventListener('submit', function(e) {
            const telefone = document.getElementById('telefone').value;
            const cpf = document.getElementById('cpf').value;
            const cep = document.getElementById('cep').value;
            
            if (telefone.length !== 11) {
                alert('Telefone deve ter 11 dígitos');
                e.preventDefault();
                return;
            }
            
            if (cpf.length !== 11) {
                alert('CPF deve ter 11 dígitos');
                e.preventDefault();
                return;
            }
            
            if (cep.length !== 8) {
                alert('CEP deve ter 8 dígitos');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>