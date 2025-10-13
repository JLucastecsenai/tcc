<?php
include "../../../validar.php";
include "../../conexao.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Verifica se o cliente tem demandas antes de excluir
    $check_demandas = mysqli_query($conn, "SELECT COUNT(*) as total FROM demandas WHERE cliente = $id");
    $total_demandas = mysqli_fetch_assoc($check_demandas)['total'];
    
    if ($total_demandas > 0) {
        header("Location: ../CLIENTES.PHP?msg=Erro: Não é possível excluir cliente com demandas associadas");
        exit;
    }
    
    $sql = "DELETE FROM cliente WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../CLIENTES.PHP?msg=Cliente excluído com sucesso");
    } else {
        header("Location: ../CLIENTES.PHP?msg=Erro ao excluir cliente");
    }
} else {
    header("Location: ../CLIENTES.PHP?msg=ID inválido");
}
exit;
?>