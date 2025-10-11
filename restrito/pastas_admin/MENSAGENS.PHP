<?php include "../../validar.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENSAGENS - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="MENSAGENS.CSS">
</head>

<body>
    <?php
    $pesquisa = $_POST['busca'] ?? '';
    include "../conexao.php";

    // Consulta para a tabela mensagem
    $sql = "SELECT * FROM mensagem WHERE nome LIKE '%$pesquisa%' OR email LIKE '%$pesquisa%' OR msg LIKE '%$pesquisa%'";
    $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-chat-dots"></i> Gerenciar Mensagens - NeoHome
            </div>

            <div class="card-body">
                <nav class="navbar navbar-light bg-light">
                    <form class="form-inline search-container" action="MENSAGENS.PHP" method="POST">
                        <input class="form-control" type="search" placeholder="Pesquisar por nome, email ou mensagem..." name="busca" value="<?php echo htmlspecialchars($pesquisa); ?>" autofocus>
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i> Pesquisar
                        </button>
                        <a href="MENSAGENS.PHP" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Limpar
                        </a>
                    </form>
                </nav>

                <?php if (mysqli_num_rows($dados) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Mensagem</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($linha = mysqli_fetch_assoc($dados)) {
                                    $id = $linha['id'];
                                    $nome = $linha['nome'];
                                    $email = $linha['email'];
                                    $telefone = $linha['telefone'];
                                    $msg = $linha['msg'];
                                    $data_msg = $linha['data_msg'];
                                    $lida = $linha['lida'] ?? 0; // Assume 0 se não existir

                                    // Formata a data
                                    $data_formatada = date('d/m/Y H:i', strtotime($data_msg));

                                    // Preview da mensagem
                                    $msg_preview = strlen($msg) > 50 ? substr($msg, 0, 50) . '...' : $msg;

                                    // Status
                                    $status_badge = $lida ?
                                        '<span class="badge bg-success status-badge">Lida</span>' :
                                        '<span class="badge bg-warning status-badge">Não Lida</span>';

                                    echo "<tr>
                                        <td>$status_badge</td>
                                        <td>$nome</td>
                                        <td>
                                            <a href='mailto:$email' class='text-decoration-none'>
                                                <i class='bi bi-envelope'></i> $email
                                            </a>
                                        </td>
                                        <td>
                                            <a href='https://wa.me/55$telefone' target='_blank' class='text-decoration-none'>
                                                <i class='bi bi-whatsapp'></i> $telefone
                                            </a>
                                        </td>
                                        <td class='mensagem-preview' title='$msg'>$msg_preview</td>
                                        <td>$data_formatada</td>
                                        <td>
                                            <div class='btn-group' role='group'>
                                                <button type='button' class='btn btn-info btn-action btn-sm' data-bs-toggle='modal' data-bs-target='#modalMsg$id'>
                                                    <i class='bi bi-eye'></i>
                                                </button>";

                                    if (!$lida) {
                                        echo "<a href='MENSAGENS/marcar_lida.php?id=$id' class='btn btn-success btn-action btn-sm'>
                                                <i class='bi bi-check-lg'></i>
                                              </a>";
                                    } else {
                                        echo "<a href='MENSAGENS/marcar_nao_lida.php?id=$id' class='btn btn-warning btn-action btn-sm'>
                                                <i class='bi bi-arrow-counterclockwise'></i>
                                              </a>";
                                    }

                                    echo "<button type='button' class='btn btn-danger btn-action btn-sm' data-bs-toggle='modal' data-bs-target='#confirma$id'>
                                            <i class='bi bi-trash'></i>
                                          </button>
                                            </div>
                                        </td>
                                    </tr>";

                                    // Modal para ver mensagem completa
                                    echo "
                                    <div class='modal fade' id='modalMsg$id' tabindex='-1'>
                                        <div class='modal-dialog modal-lg'>
                                            <div class='modal-content'>
                                                <div class='modal-header bg-primary text-white'>
                                                    <h5 class='modal-title'>Mensagem de $nome</h5>
                                                    <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <p><strong><i class='bi bi-envelope'></i> Email:</strong> $email</p>
                                                    <p><strong><i class='bi bi-telephone'></i> Telefone:</strong> $telefone</p>
                                                    <p><strong><i class='bi bi-calendar'></i> Data:</strong> $data_formatada</p>
                                                    <hr>
                                                    <p><strong>Mensagem:</strong></p>
                                                    <div class='border p-3 bg-light rounded'>
                                                        " . nl2br(htmlspecialchars($msg)) . "
                                                    </div>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                                                    " . (!$lida ? "<a href='MENSAGENS/marcar_lida.php?id=$id' class='btn btn-success'>Marcar como Lida</a>" : "") . "
                                                </div>
                                            </div>
                                        </div>
                                    </div>";

                                    // Modal de confirmação de exclusão
                                    echo "
                                    <div class='modal fade' id='confirma$id' tabindex='-1'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header bg-danger text-white'>
                                                    <h5 class='modal-title'>Confirmar Exclusão</h5>
                                                    <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <p>Tem certeza que deseja excluir a mensagem de <b>$nome</b>?</p>
                                                    <p class='text-muted'><small>Esta ação não pode ser desfeita.</small></p>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                    <a href='MENSAGENS/excluir_mensagem.php?id=$id' class='btn btn-danger'>Excluir Mensagem</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #6c757d;"></i>
                        <h3 class="mt-3">Nenhuma mensagem encontrada</h3>
                        <p class="text-muted">
                            <?php echo $pesquisa ?
                                "Nenhum resultado para: <strong>'$pesquisa'</strong>" :
                                "Não há mensagens no sistema."; ?>
                        </p>
                        <?php if ($pesquisa): ?>
                            <a href="MENSAGENS.PHP" class="btn btn-primary">
                                <i class="bi bi-arrow-clockwise"></i> Ver todas as mensagens
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <div class="btn-group">
                        <a href="../admin_homepage.php" class="btn btn-info">
                            <i class="bi bi-arrow-left"></i> Voltar para o Dashboard
                        </a>
                        <a href="../../index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-house"></i> Ir para o Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Função para mostrar detalhes da mensagem
        function verMensagem(id, nome, email, telefone, msg, data) {
            document.getElementById('modalNome').innerText = nome;
            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalTelefone').innerText = telefone;
            document.getElementById('modalMensagem').innerText = msg;
            document.getElementById('modalData').innerText = data;
        }

        // Auto-focus na pesquisa
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="busca"]');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        });
    </script>
</body>

</html>