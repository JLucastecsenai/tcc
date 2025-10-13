<?php include "../../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-header {
            background-color: #0c0a33;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php
    include "../../conexao.php";
    
    // Buscar todos os cargos
    $sql_cargos = "SELECT id, funcao, salario FROM cargos ORDER BY funcao ASC";
    $cargos = mysqli_query($conn, $sql_cargos);
    ?>

    <div class="form-container">
        <div class="form-header">
            <h3><i class="bi bi-person-plus"></i> Cadastrar Novo Funcionário</h3>
        </div>

        <form action="processar_cadastro.php" method="POST">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="nome" class="form-label">Nome Completo *</label>
                    <input type="text" class="form-control" id="nome" name="nome" required maxlength="128">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="128">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone *</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" required maxlength="11" placeholder="11999999999">
                    <small class="text-muted">Apenas números (DDD + número)</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cpf" class="form-label">CPF *</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="11" placeholder="00000000000">
                    <small class="text-muted">Apenas números</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cargo" class="form-label">Cargo *</label>
                    <select class="form-select" id="cargo" name="cargo" required>
                        <option value="">Selecione um cargo</option>
                        <?php while ($cargo = mysqli_fetch_assoc($cargos)): ?>
                            <?php $salario_formatado = 'R$ ' . number_format($cargo['salario'], 2, ',', '.'); ?>
                            <option value="<?php echo $cargo['id']; ?>">
                                <?php echo $cargo['funcao'] . " - " . $salario_formatado; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="../FUNCIONARIOS.PHP" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Cadastrar Funcionário
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validação de CPF apenas números
        document.getElementById('cpf').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });

        // Validação de telefone apenas números
        document.getElementById('telefone').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>