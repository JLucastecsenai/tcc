<?php
include "../../../validar.php";
include "../../conexao.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../CLIENTES.PHP");
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM cliente WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../CLIENTES.PHP?msg=Cliente não encontrado");
    exit;
}

$cliente = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - NeoHome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Editar Cliente</h4>
            </div>
            <div class="card-body">
                <form action="editar_cliente_script.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?php echo htmlspecialchars($cliente['nome']); ?>" required maxlength="128">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($cliente['email']); ?>" required maxlength="128">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" 
                                   value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required 
                                   pattern="[0-9]{11}" placeholder="11999999999" maxlength="11">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF *</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" 
                                   value="<?php echo htmlspecialchars($cliente['cpf']); ?>" required 
                                   pattern="[0-9]{11}" placeholder="12345678900" maxlength="11" readonly>
                            <small class="text-muted">CPF não pode ser alterado</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cep" class="form-label">CEP *</label>
                            <input type="text" class="form-control" id="cep" name="cep" 
                                   value="<?php echo htmlspecialchars($cliente['cep']); ?>" required 
                                   pattern="[0-9]{8}" placeholder="12345678" maxlength="8">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="numero_casa" class="form-label">Número</label>
                            <input type="number" class="form-control" id="numero_casa" name="numero_casa" 
                                   value="<?php echo htmlspecialchars($cliente['numero_casa']); ?>" 
                                   min="1" max="99999">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" 
                                   value="<?php echo htmlspecialchars($cliente['complemento']); ?>" 
                                   maxlength="30">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="../CLIENTES.PHP" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-lg"></i> Atualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Formatação dos campos numéricos
        document.getElementById('telefone').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
        
        document.getElementById('cep').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>