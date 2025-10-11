<?php include "../../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARGOS - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 1000px;
            margin-top: 50px;
        }
        .card-header {
            background-color: #0c0a33;
            color: white;
            text-align: center;
            font-size: 24px;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .table th {
            background-color: rgb(108, 119, 131);
            color: white;
            text-align: center;
            vertical-align: middle;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }
        .new-cargo-btn {
            margin-bottom: 20px;
            text-align: right;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <?php
    include "../../conexao.php";

    // Consulta para buscar todos os cargos
    $sql = "SELECT 
            cargos.id,
            cargos.funcao,
            cargos.salario,
            COUNT(funcionarios.id) as total_funcionarios
            FROM cargos
            LEFT JOIN funcionarios ON cargos.id = funcionarios.cargo
            GROUP BY cargos.id, cargos.funcao, cargos.salario
            ORDER BY cargos.funcao ASC";
    $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <div class="card-header">Gerenciar Cargos - admin</div>

        <!-- Botão Novo Cargo -->
        <div class="new-cargo-btn">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNovoCargo">
                <i class="bi bi-plus-circle"></i> Novo Cargo
            </button>
        </div>

        <?php if (mysqli_num_rows($dados) > 0): ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Função</th>
                        <th>Salário</th>
                        <th>Funcionários</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($dados)) {
                        $id = $linha['id'];
                        $funcao = $linha['funcao'];
                        $salario = $linha['salario'];
                        $total_funcionarios = $linha['total_funcionarios'];

                        // Formata o salário
                        $salario_formatado = 'R$ ' . number_format($salario, 2, ',', '.');

                        echo "<tr>
                            <td><strong>$funcao</strong></td>
                            <td>$salario_formatado</td>
                            <td><span class='badge bg-info'>$total_funcionarios funcionário(s)</span></td>
                            <td>
                                <div class='action-buttons'>
                                    <button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar$id' title='Editar'>
                                        <i class='bi bi-pencil'></i>
                                    </button>
                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma$id' title='Excluir'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>";

                        // Modal para editar cargo
                        echo "
                        <div class='modal fade' id='modalEditar$id' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-pencil'></i> Editar Cargo</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <form action='editar_cargo.php' method='POST'>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id' value='$id'>
                                            <div class='mb-3'>
                                                <label for='funcao$id' class='form-label'>Função *</label>
                                                <input type='text' class='form-control' id='funcao$id' name='funcao' value='$funcao' required maxlength='128'>
                                            </div>
                                            <div class='mb-3'>
                                                <label for='salario$id' class='form-label'>Salário (R$) *</label>
                                                <input type='number' class='form-control' id='salario$id' name='salario' value='$salario' step='0.01' min='0' required>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-success'>
                                                <i class='bi bi-check-lg'></i> Salvar Alterações
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";

                        // Modal de confirmação de exclusão
                        $pode_excluir = ($total_funcionarios == 0);
                        echo "
                        <div class='modal fade' id='confirma$id' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Confirmação de Exclusão</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <div class='modal-body'>";
                        
                        if ($pode_excluir) {
                            echo "<p>Deseja realmente excluir o cargo <b>$funcao</b>?</p>
                                  <p class='text-muted'><small>Salário: $salario_formatado</small></p>";
                        } else {
                            echo "<div class='alert alert-warning'>
                                    <i class='bi bi-exclamation-triangle'></i> 
                                    <strong>Não é possível excluir este cargo!</strong>
                                  </div>
                                  <p>O cargo <b>$funcao</b> possui <b>$total_funcionarios funcionário(s)</b> vinculado(s).</p>
                                  <p class='text-muted'>Para excluir este cargo, primeiro altere o cargo dos funcionários vinculados.</p>";
                        }
                        
                        echo "  </div>
                                    <div class='modal-footer'>";
                        
                        if ($pode_excluir) {
                            echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                  <a href='excluir_cargo.php?id=$id' class='btn btn-danger'>Excluir</a>";
                        } else {
                            echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>";
                        }
                        
                        echo "  </div>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-briefcase"></i>
                <h3>Nenhum cargo cadastrado</h3>
                <p>Não há cargos cadastrados no sistema.</p>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNovoCargo">
                    <i class="bi bi-plus-circle"></i> Cadastrar Primeiro Cargo
                </button>
            </div>
        <?php endif; ?>

        <!-- Rodapé com Navegação -->
        <div class="d-flex justify-content-between mt-4">
            <a href="../FUNCIONARIOS.PHP" class="btn btn-info" style="background-color: #0c0a33; color: #fff;">
                <i class="bi bi-arrow-left"></i> Voltar para Funcionários
            </a>
            <a href="../../admin_homepage.php" class="btn btn-secondary" style="background-color: #6c757d; color: #fff;">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Modal para criar novo cargo -->
    <div class="modal fade" id="modalNovoCargo" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Novo Cargo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="criar_cargo.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="funcao_nova" class="form-label">Função *</label>
                            <input type="text" class="form-control" id="funcao_nova" name="funcao" required maxlength="128" placeholder="Ex: Desenvolvedor, Analista, Gerente...">
                        </div>
                        <div class="mb-3">
                            <label for="salario_novo" class="form-label">Salário (R$) *</label>
                            <input type="number" class="form-control" id="salario_novo" name="salario" step="0.01" min="0" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Cadastrar Cargo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>