<?php include "../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUNCIONÁRIOS - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="FUNCIONARIOS.css">
</head>
<body>
    <?php
    $pesquisa = $_POST['busca'] ?? '';
    include "../conexao.php";

    // Remove caracteres especiais da pesquisa
    $pesquisa_limpa = preg_replace('/[^0-9a-zA-Z@.\s]/', '', $pesquisa);

    // Consulta para a tabela funcionarios com JOIN na tabela cargos
    $sql = "SELECT 
            funcionarios.id,
            funcionarios.nome,
            funcionarios.email,
            funcionarios.telefone,
            funcionarios.cpf,
            funcionarios.cargo AS cargo_id,
            cargos.funcao AS cargo_nome,
            cargos.salario
            FROM funcionarios
            INNER JOIN cargos ON funcionarios.cargo = cargos.id
            WHERE 
            funcionarios.nome LIKE '%$pesquisa%' OR 
            funcionarios.email LIKE '%$pesquisa%' OR 
            funcionarios.telefone LIKE '%$pesquisa_limpa%' OR 
            funcionarios.cpf LIKE '%$pesquisa_limpa%' OR
            cargos.funcao LIKE '%$pesquisa%'
            ORDER BY funcionarios.nome ASC";
    $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <div class="card-header" style="background-color: #0c0a33;">Gerenciar Funcionários - admin</div>

        <!-- Botões de ação -->
        <div class="new-item-btn">
            <a href="FUNCIONARIOS/cadastrar_funcionario.php" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Novo Funcionário
            </a>
            <a href="CARGOS/gerenciar_cargos.php" class="btn btn-primary">
                <i class="bi bi-briefcase"></i> Gerenciar Cargos
            </a>
        </div>

        <!-- Barra de Pesquisa -->
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline search-container" action="FUNCIONARIOS.PHP" method="POST">
                <input class="form-control" type="search" placeholder="Pesquisar por nome, email, telefone, CPF ou cargo..." name="busca" value="<?php echo htmlspecialchars($pesquisa); ?>" autofocus>
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i> Pesquisar
                </button>
            </form>
        </nav>

        <?php if (mysqli_num_rows($dados) > 0): ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Cargo</th>
                        <th>Salário</th>
                        <th>Funções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($dados)) {
                        $id = $linha['id'];
                        $nome = $linha['nome'];
                        $email = $linha['email'];
                        $telefone = $linha['telefone'];
                        $cpf = $linha['cpf'];
                        $cargo_id = $linha['cargo_id'];
                        $cargo_nome = $linha['cargo_nome'];
                        $salario = $linha['salario'];

                        // Formata o CPF
                        $cpf_formatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);

                        // Formata o telefone
                        $telefone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);

                        // Formata o salário
                        $salario_formatado = 'R$ ' . number_format($salario, 2, ',', '.');

                        echo "<tr>
                            <td><strong>$nome</strong></td>
                            <td>$email</td>
                            <td>$telefone_formatado</td>
                            <td>$cpf_formatado</td>
                            <td><span class='badge bg-primary'>$cargo_nome</span></td>
                            <td>$salario_formatado</td>
                            <td>
                                <div class='action-buttons'>
                                    <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalFuncionario$id' title='Ver Detalhes'>
                                        <i class='bi bi-eye'></i>
                                    </button>
                                    <a href='FUNCIONARIOS/editar_funcionario.php?id=$id' class='btn btn-success btn-sm' title='Editar'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalCargo$id' title='Alterar Cargo'>
                                        <i class='bi bi-arrow-repeat'></i>
                                    </button>
                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma$id' title='Excluir'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>";

                        // Modal para ver funcionário completo
                        echo "
                        <div class='modal fade' id='modalFuncionario$id' tabindex='-1'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-person-badge'></i> Detalhes do Funcionário</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <div class='row'>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Nome:</strong><br>$nome
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <strong>CPF:</strong><br>$cpf_formatado
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Email:</strong><br>$email
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Telefone:</strong><br>$telefone_formatado
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Cargo:</strong><br><span class='badge bg-primary'>$cargo_nome</span>
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Salário:</strong><br>$salario_formatado
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                                        <a href='FUNCIONARIOS/editar_funcionario.php?id=$id' class='btn btn-success'>
                                            <i class='bi bi-pencil'></i> Editar Funcionário
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>";

                        // Modal para alterar cargo
                        echo "
                        <div class='modal fade' id='modalCargo$id' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-arrow-repeat'></i> Alterar Cargo</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <form action='FUNCIONARIOS/alterar_cargo.php' method='POST'>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id_funcionario' value='$id'>
                                            <p><strong>Funcionário:</strong> $nome</p>
                                            <p><strong>Cargo Atual:</strong> <span class='badge bg-primary'>$cargo_nome</span></p>
                                            <div class='mb-3'>
                                                <label for='novo_cargo$id' class='form-label'><strong>Novo Cargo:</strong></label>
                                                <select class='form-select' id='novo_cargo$id' name='novo_cargo' required>";
                                                
                                                // Buscar todos os cargos disponíveis
                                                $sql_cargos = "SELECT id, funcao, salario FROM cargos ORDER BY funcao ASC";
                                                $result_cargos = mysqli_query($conn, $sql_cargos);
                                                while ($cargo = mysqli_fetch_assoc($result_cargos)) {
                                                    $selected = ($cargo['id'] == $cargo_id) ? 'selected' : '';
                                                    $salario_cargo = 'R$ ' . number_format($cargo['salario'], 2, ',', '.');
                                                    echo "<option value='{$cargo['id']}' $selected>{$cargo['funcao']} - $salario_cargo</option>";
                                                }
                                                
                        echo "              </select>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                            <button type='submit' class='btn btn-warning'>
                                                <i class='bi bi-arrow-repeat'></i> Alterar Cargo
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";

                        // Modal de confirmação de exclusão
                        echo "
                        <div class='modal fade' id='confirma$id' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Confirmação de Exclusão</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Deseja realmente excluir <b>$nome</b>?</p>
                                        <p class='text-muted'><small>CPF: $cpf_formatado</small></p>
                                        <p class='text-muted'><small>Cargo: $cargo_nome</small></p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                        <a href='FUNCIONARIOS/excluir_funcionario.php?id=$id' class='btn btn-danger'>Excluir</a>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h3>Nenhum funcionário encontrado</h3>
                <p>
                    <?php echo $pesquisa ?
                        "Nenhum resultado para: <strong>'$pesquisa'</strong>" :
                        "Não há funcionários cadastrados no sistema."; ?>
                </p>
                <?php if (!$pesquisa): ?>
                    <a href="FUNCIONARIOS/cadastrar_funcionario.php" class="btn btn-success">
                        <i class="bi bi-person-plus"></i> Cadastrar Primeiro Funcionário
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Rodapé com Navegação -->
        <div class="btn-group">
            <a href="../admin_homepage.php" class="btn btn-info" style="background-color: #0c0a33; color: #fff;">
                <i class="bi bi-arrow-left"></i> Voltar para o Dashboard
            </a>
            <a href="../../index.php" class="btn btn-secondary;" style="background-color: #6c757d; color: #fff;">
                <i class="bi bi-house"></i> Ir para o Site
            </a>
        </div>
    </div>

    <!-- Scripts Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-focus na pesquisa
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="busca"]');
            if (searchInput) {
                searchInput.focus();
            }
        });
    </script>
</body>

</html>