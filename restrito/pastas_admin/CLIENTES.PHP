<?php include "../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENTES - NeoHome Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CLIENTES.css">
</head>
<body>
    <?php
    $pesquisa = $_POST['busca'] ?? '';
    include "../conexao.php";

    // Remove caracteres especiais da pesquisa para buscar CPF, telefone e CEP sem formatação
    $pesquisa_limpa = preg_replace('/[^0-9a-zA-Z@.\s]/', '', $pesquisa);

    // Consulta para a tabela cliente
    $sql = "SELECT * FROM cliente WHERE 
            nome LIKE '%$pesquisa%' OR 
            email LIKE '%$pesquisa%' OR 
            telefone LIKE '%$pesquisa_limpa%' OR 
            cpf LIKE '%$pesquisa_limpa%' OR
            cep LIKE '%$pesquisa_limpa%' OR
            numero_casa LIKE '%$pesquisa%' OR
            complemento LIKE '%$pesquisa%'
            ORDER BY nome ASC";
    $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <div class="card-header">Gerenciar Clientes - NeoHome</div>

        <!-- Botão Novo Cliente -->
        <div class="new-client-btn">
            <a href="cadastrar_cliente.php" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Novo Cliente
            </a>
        </div>

        <!-- Barra de Pesquisa -->
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline search-container" action="CLIENTES.PHP" method="POST">
                <input class="form-control" type="search" placeholder="Pesquisar por nome, email, telefone, CPF ou CEP..." name="busca" value="<?php echo htmlspecialchars($pesquisa); ?>" autofocus>
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
                        <th>Endereço</th>
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
                        $cep = $linha['cep'];
                        $numero_casa = $linha['numero_casa'];
                        $complemento = $linha['complemento'];

                        // Formata o CPF
                        $cpf_formatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);

                        // Formata o telefone
                        $telefone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);

                        // Formata o CEP
                        $cep_formatado = preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cep);

                        // Monta o endereço completo
                        $endereco_completo = "CEP: $cep_formatado";
                        if ($numero_casa) {
                            $endereco_completo .= " - Nº $numero_casa";
                        }
                        if ($complemento) {
                            $endereco_completo .= " - $complemento";
                        }

                        echo "<tr>
                            <td><strong>$nome</strong></td>
                            <td>$email</td>
                            <td>$telefone_formatado</td>
                            <td>$cpf_formatado</td>
                            <td>$endereco_completo</td>
                            <td>
                                <div class='action-buttons'>
                                    <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalCliente$id' title='Ver Detalhes'>
                                        <i class='bi bi-eye'></i>
                                    </button>
                                    <a href='editar_cliente.php?id=$id' class='btn btn-success btn-sm' title='Editar'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma$id' onclick='pegar_dados($id, \"$nome\")' title='Excluir'>
                                        <i class='bi bi-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>";

                        // Modal para ver cliente completo
                        echo "
                        <div class='modal fade' id='modalCliente$id' tabindex='-1'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'><i class='bi bi-person-badge'></i> Detalhes do Cliente</h5>
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
                                            <div class='col-md-12 mb-3'>
                                                <strong>Endereço:</strong><br>$endereco_completo
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                                        <a href='editar_cliente.php?id=$id' class='btn btn-success'>
                                            <i class='bi bi-pencil'></i> Editar Cliente
                                        </a>
                                    </div>
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
                                        <p>Deseja realmente excluir <b id='nome_pessoa$id'>$nome</b>?</p>
                                        <p class='text-muted'><small>CPF: $cpf_formatado</small></p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                        <a href='excluir_cliente.php?id=$id' class='btn btn-danger'>Excluir</a>
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
                <h3>Nenhum cliente encontrado</h3>
                <p>
                    <?php echo $pesquisa ?
                        "Nenhum resultado para: <strong>'$pesquisa'</strong>" :
                        "Não há clientes cadastrados no sistema."; ?>
                </p>
                <?php if (!$pesquisa): ?>
                    <a href="cadastrar_cliente.php" class="btn btn-success">
                        <i class="bi bi-person-plus"></i> Cadastrar Primeiro Cliente
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Rodapé com Navegação -->
        <div class="btn-group">
            <a href="../admin_homepage.php" class="btn btn-info">
                <i class="bi bi-arrow-left"></i> Voltar para o Dashboard
            </a>
            <a href="../../index.php" class="btn btn-secondary">
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

        function pegar_dados(id, nome) {
            document.getElementById('nome_pessoa' + id).innerText = nome;
        }
    </script>
</body>

</html>