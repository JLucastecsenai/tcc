<?php
include "../../validar.php";
include "../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Verifica se a coluna 'lida' existe, se não, altera a tabela
    $check_column = mysqli_query($conn, "SHOW COLUMNS FROM mensagem LIKE 'lida'");
    if (mysqli_num_rows($check_column) == 0) {
        mysqli_query($conn, "ALTER TABLE mensagem ADD COLUMN lida TINYINT(1) DEFAULT 0");
    }
    
    $sql = "UPDATE mensagem SET lida = 1 WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: MENSAGENS.PHP?msg=Mensagem marcada como lida");
    } else {
        header("Location: MENSAGENS.PHP?msg=Erro ao marcar mensagem como lida");
    }
} else {
    header("Location: MENSAGENS.PHP?msg=ID inválido");
}
exit;
?>
