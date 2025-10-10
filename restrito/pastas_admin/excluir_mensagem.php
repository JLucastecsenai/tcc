<?php
include "../../validar.php";
include "../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM mensagem WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: MENSAGENS.PHP?msg=Mensagem excluída com sucesso");
    } else {
        header("Location: MENSAGENS.PHP?msg=Erro ao excluir mensagem");
    }
} else {
    header("Location: MENSAGENS.PHP?msg=ID inválido");
}
exit;
?>