<?php
include "../../validar.php";
include "../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE mensagem SET lida = 0 WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: MENSAGENS.PHP?msg=Mensagem marcada como não lida");
    } else {
        header("Location: MENSAGENS.PHP?msg=Erro ao marcar mensagem como não lida");
    }
} else {
    header("Location: MENSAGENS.PHP?msg=ID inválido");
}
exit;
?>
