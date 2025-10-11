<?php include "../../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Demanda - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="cadastrar_demanda.css">
</head>
<body>
    <?php
    include "../../conexao.php";
    
    // Recebe o ID da demanda
    $id = $_GET['id'] ?? '';
    
    if (empty($id) || !is_numeric($id)) {
        echo "<script>
                alert('ID inválido!');
                window.location.href = '../DEMANDAS.php';
              </script>";
        exit;
    }
    
    $id = mysqli_real_escape_string($conn, $id);
    
    // Busca os dados da demanda
    $sql = "SELECT * FROM demandas WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        echo "<script>
                alert('Demanda não encontrada!');
                window.location.href = '../DEMANDAS.php';
              </script>";
        exit;
    }
    
    $demanda_data = mysqli_fetch_assoc($result);
    
    // Buscar todos os clientes para o select
    $sql_clientes = "SELECT id, nome FROM cliente ORDER BY nome ASC";
    $result_clientes = mysqli_query($conn, $sql_clientes);
    
    // Buscar funcionários destacados nesta demanda
    $sql_func_destacados = "SELECT id_funcionarios FROM funcionario_demanda WHERE id_demanda = '$id'";
    $result_func_destacados = mysqli_query($conn, $sql_func_destacados);
    $funcionarios_destacados = [];
    while ($fd = mysqli_fetch_assoc($result_func_destacados)) {
        $funcionarios_destacados[] = $fd['id_funcionarios'];
    }
    ?>

    <div class="container">
        <div class="card-header" style="background-color: #0c0a33;">Editar Demanda #<?php echo $id; ?> - admin</div>

        <div class="form-card">
            <form action="editar_demanda_script.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                
                <!-- Informações da Demanda -->
                <div class="form-section">
                    <h5><i class="bi bi-clipboard-check"></i> Informações da Demanda</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cliente" class="form-label">Cliente *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <select class="form-select" id="cliente" name="cliente" required>
                                    <option value="">Selecione um cliente...</option>
                                    <?php
                                    while ($cliente = mysqli_fetch_assoc($result_clientes)) {
                                        $selected = ($cliente['id'] == $demanda_data['cliente']) ? 'selected' : '';
                                        echo "<option value='{$cliente['id']}' $selected>{$cliente['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <small class="text-muted">Selecione o cliente responsável pela demanda</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="data_demanda" class="form-label">Data da Demanda *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" class="form-control" id="data_demanda" name="data_demanda" 
                                       value="<?php echo $demanda_data['data_demanda']; ?>" required>
                            </div>
                            <small class="text-muted">Data em que a demanda foi/será solicitada (não permite datas passadas)</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="demanda" class="form-label">Descrição da Demanda *</label>
                            <textarea class="form-control" id="demanda" name="demanda" rows="8" required maxlength="500" placeholder="Descreva detalhadamente a demanda do cliente..."><?php echo htmlspecialchars($demanda_data['demanda']); ?></textarea>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Máximo de 500 caracteres</small>
                                <small class="text-muted"><span id="charCount"><?php echo strlen($demanda_data['demanda']); ?></span>/500</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Funcionários -->
                <div class="form-section">
                    <h5><i class="bi bi-people"></i> Destacar Funcionários (Opcional)</h5>
                    
                    <?php
                    // Buscar todos os funcionários
                    $sql_funcionarios = "SELECT id, nome FROM funcionarios ORDER BY nome ASC";
                    $result_funcionarios = mysqli_query($conn, $sql_funcionarios);
                    
                    if (mysqli_num_rows($result_funcionarios) > 0): ?>
                        <p class="text-muted mb-3">Selecione os funcionários que trabalharão nesta demanda:</p>
                        <div class="funcionarios-checkbox-grid">
                            <?php while ($func = mysqli_fetch_assoc($result_funcionarios)): 
                                $checked = in_array($func['id'], $funcionarios_destacados) ? 'checked' : '';
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="funcionarios[]" 
                                           value="<?php echo $func['id']; ?>" id="func<?php echo $func['id']; ?>" <?php echo $checked; ?>>
                                    <label class="form-check-label" for="func<?php echo $func['id']; ?>">
                                        <?php echo $func['nome']; ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Nenhum funcionário cadastrado no sistema.</p>
                    <?php endif; ?>
                </div>
                
                <!-- Rodapé com Navegação -->
                <div class="btn-group">
                    <a href="../DEMANDAS.php" class="btn btn-info" style="background-color: #0c0a33; color: #fff;">
                        <i class="bi bi-arrow-left"></i> Voltar para Lista
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Define data MÍNIMA como hoje (permite hoje e futuro, bloqueia passado)
        document.addEventListener('DOMContentLoaded', function() {
            const dataInput = document.getElementById('data_demanda');
            const hoje = new Date().toISOString().split('T')[0];
            dataInput.min = hoje; // Define data mínima (NÃO permite passado)
        });

        // Contador de caracteres
        const demandaTextarea = document.getElementById('demanda');
        const charCount = document.getElementById('charCount');
        
        demandaTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count >= 500) {
                charCount.style.color = 'red';
                charCount.style.fontWeight = 'bold';
            } else if (count >= 450) {
                charCount.style.color = 'orange';
                charCount.style.fontWeight = 'bold';
            } else {
                charCount.style.color = '#6c757d';
                charCount.style.fontWeight = 'normal';
            }
        });

        // Validação do formulário
        document.querySelector('form').addEventListener('submit', function(e) {
            const cliente = document.getElementById('cliente').value;
            const data = document.getElementById('data_demanda').value;
            const demanda = document.getElementById('demanda').value.trim();
            
            if (!cliente) {
                alert('Por favor, selecione um cliente');
                e.preventDefault();
                return;
            }
            
            if (!data) {
                alert('Por favor, informe a data da demanda');
                e.preventDefault();
                return;
            }
            
            // Validação adicional: verifica se a data não é passada
            const hoje = new Date().toISOString().split('T')[0];
            if (data < hoje) {
                alert('Não é permitido definir datas passadas para a demanda!');
                e.preventDefault();
                return;
            }
            
            if (demanda.length < 10) {
                alert('A descrição da demanda deve ter pelo menos 10 caracteres');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>