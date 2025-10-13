<?php include "../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMANDAS - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="DEMANDAS.css">
</head>
<body>
    <?php
    $pesquisa = $_POST['busca'] ?? '';
    include "../conexao.php";

    // Remove caracteres especiais da pesquisa
    $pesquisa_limpa = preg_replace('/[^0-9a-zA-Z@.\s]/', '', $pesquisa);

    // Consulta para a tabela demandas com JOIN para pegar o nome do cliente
    $sql = "SELECT 
                demandas.id,
                demandas.cliente AS cliente_id,
                cliente.nome AS cliente_nome,
                demandas.demanda,
                demandas.data_demanda
            FROM demandas
            INNER JOIN cliente ON demandas.cliente = cliente.id
            WHERE 
                cliente.nome LIKE '%$pesquisa%' OR 
                demandas.demanda LIKE '%$pesquisa%' OR
                demandas.data_demanda LIKE '%$pesquisa%'
            ORDER BY demandas.data_demanda DESC";
    $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <div class="card-header" style="background-color: #0c0a33;">Gerenciar Demandas - admin</div>

        <!-- Botão Nova Demanda -->
        <div class="new-demand-btn">
            <a href="DEMANDAS/cadastrar_demanda.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Nova Demanda
            </a>
        </div>

        <!-- Barra de Pesquisa -->
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline search-container" action="DEMANDAS.PHP" method="POST">
                <input class="form-control" type="search" placeholder="Pesquisar por cliente, demanda ou data..." name="busca" value="<?php echo htmlspecialchars($pesquisa); ?>" autofocus>
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i> Pesquisar
                </button>
            </form>
        </nav>

        <?php if (mysqli_num_rows($dados) > 0): ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Demanda</th>
                        <th>Data</th>
                        <th>Funcionários</th>
                        <th>Funções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($dados)) {
                        $id = $linha['id'];
                        $cliente_id = $linha['cliente_id'];
                        $cliente_nome = $linha['cliente_nome'];
                        $demanda = $linha['demanda'];
                        $data_demanda = $linha['data_demanda'];

                        // Formata a data
                        $data_formatada = date('d/m/Y', strtotime($data_demanda));

                        // Trunca a demanda para exibição na tabela
                        $demanda_resumida = strlen($demanda) > 100 ? substr($demanda, 0, 100) . '...' : $demanda;

                        // Busca os funcionários destacados para esta demanda
                        $sql_funcionarios = "SELECT f.id, f.nome 
                                           FROM funcionarios f
                                           INNER JOIN funcionario_demanda fd ON f.id = fd.id_funcionarios
                                           WHERE fd.id_demanda = '$id'";
                        $result_func = mysqli_query($conn, $sql_funcionarios);
                        $funcionarios = [];
                        while ($func = mysqli_fetch_assoc($result_func)) {
                            $funcionarios[] = $func['nome'];
                        }
                        $funcionarios_text = count($funcionarios) > 0 ? implode(', ', $funcionarios) : '<span class="text-muted">Nenhum</span>';
                        $funcionarios_count = count($funcionarios);

                        echo "<tr>
                            <td><strong>#$id</strong></td>
                            <td>$cliente_nome</td>
                            <td>$demanda_resumida</td>
                            <td>$data_formatada</td>
                            <td>
                                <span class='badge bg-info'>$funcionarios_count</span>
                            </td>
                            <td>
                                <div class='action-buttons'>
                                    <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalDemanda$id' title='Ver Detalhes'>
                                        <i class='bi bi-eye'></i>
                                    </button>
                                    <button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalFuncionarios$id' title='Gerenciar Funcionários'>
                                        <i class='bi bi-people'></i>
                                    </button>
                                    <a href='DEMANDAS/editar_demanda.php?id=$id' class='btn btn-success btn-sm' title='Editar'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma$id' title='Excluir'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>";

                        // Modal para ver demanda completa
                        echo "
                        <div class='modal fade' id='modalDemanda$id' tabindex='-1'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-clipboard-check'></i> Detalhes da Demanda #$id</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <div class='row'>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Cliente:</strong><br>$cliente_nome
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <strong>Data da Demanda:</strong><br>$data_formatada
                                            </div>
                                            <div class='col-md-12 mb-3'>
                                                <strong>Descrição Completa:</strong><br>
                                                <div class='demanda-content'>$demanda</div>
                                            </div>
                                            <div class='col-md-12 mb-3'>
                                                <strong>Funcionários Destacados:</strong><br>
                                                <div class='funcionarios-list'>$funcionarios_text</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                                        <button type='button' class='btn btn-warning' data-bs-dismiss='modal' data-bs-toggle='modal' data-bs-target='#modalFuncionarios$id'>
                                            <i class='bi bi-people'></i> Gerenciar Funcionários
                                        </button>
                                        <a href='DEMANDAS/editar_demanda.php?id=$id' class='btn btn-success'>
                                            <i class='bi bi-pencil'></i> Editar Demanda
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>";

                        // Modal para gerenciar funcionários
                        $sql_todos_func = "SELECT id, nome FROM funcionarios ORDER BY nome ASC";
                        $result_todos_func = mysqli_query($conn, $sql_todos_func);
                        
                        echo "
                        <div class='modal fade' id='modalFuncionarios$id' tabindex='-1'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-people'></i> Gerenciar Funcionários - Demanda #$id</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <form action='DEMANDAS/gerenciar_funcionarios_demanda.php' method='POST'>
                                        <input type='hidden' name='demanda_id' value='$id'>
                                        <div class='modal-body'>
                                            <p class='mb-3'><strong>Cliente:</strong> $cliente_nome</p>
                                            <p class='mb-3'><strong>Selecione os funcionários para esta demanda:</strong></p>
                                            <div class='funcionarios-checkbox-list'>";
                        
                        // Busca IDs dos funcionários já destacados
                        $sql_func_dest = "SELECT id_funcionarios FROM funcionario_demanda WHERE id_demanda = '$id'";
                        $result_func_dest = mysqli_query($conn, $sql_func_dest);
                        $funcionarios_destacados = [];
                        while ($fd = mysqli_fetch_assoc($result_func_dest)) {
                            $funcionarios_destacados[] = $fd['id_funcionarios'];
                        }
                        
                        mysqli_data_seek($result_todos_func, 0);
                        while ($func = mysqli_fetch_assoc($result_todos_func)) {
                            $checked = in_array($func['id'], $funcionarios_destacados) ? 'checked' : '';
                            echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='funcionarios[]' value='{$func['id']}' id='func{$func['id']}_demanda$id' $checked>
                                    <label class='form-check-label' for='func{$func['id']}_demanda$id'>
                                        {$func['nome']}
                                    </label>
                                </div>";
                        }
                        
                        echo "
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
                        echo "
                        <div class='modal fade' id='confirma$id' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-exclamation-triangle text-danger'></i> Confirmação de Exclusão</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                    </div>
                                    <form action='DEMANDAS/excluir_demanda_script.php' method='POST'>
                                        <input type='hidden' name='id' value='$id'>
                                        <div class='modal-body'>
                                            <p>Deseja realmente excluir a demanda <b>#$id</b>?</p>
                                            <p class='text-muted'><small>Cliente: $cliente_nome | Data: $data_formatada</small></p>
                                            <p class='text-danger'><small><i class='bi bi-info-circle'></i> Esta ação não pode ser desfeita!</small></p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>
                                                <i class='bi bi-x-circle'></i> Cancelar
                                            </button>
                                            <button type='submit' class='btn btn-danger'>
                                                <i class='bi bi-trash'></i> Confirmar Exclusão
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-clipboard-x"></i>
                <h3>Nenhuma demanda encontrada</h3>
                <p>
                    <?php echo $pesquisa ?
                        "Nenhum resultado para: <strong>'$pesquisa'</strong>" :
                        "Não há demandas cadastradas no sistema."; ?>
                </p>
                <?php if (!$pesquisa): ?>
                    <a href="DEMANDAS/cadastrar_demanda.php" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Cadastrar Primeira Demanda
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Rodapé com Navegação -->
        <div class="btn-group">
            <a href="../admin_homepage.php" class="btn btn-info" style="background-color: #0c0a33; color: #fff;">
                <i class="bi bi-arrow-left"></i> Voltar para o Dashboard
            </a>
            <a href="../../index.php" class="btn btn-secondary" style="background-color: #6c757d; color: #fff;">
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