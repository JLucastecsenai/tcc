<?php
include "../../../validar.php";
include "../../conexao.php";

// Recebe o ID da demanda
$id = $_POST['id'] ?? $_GET['id'] ?? '';

// Validação
if (empty($id) || !is_numeric($id)) {
    echo "<script>
            alert('ID inválido!');
            window.location.href = '../DEMANDAS.php';
          </script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $id);

// Verifica se a demanda existe
$sql_check_demanda = "SELECT id FROM demandas WHERE id = '$id'";
$result_check_demanda = mysqli_query($conn, $sql_check_demanda);

if (mysqli_num_rows($result_check_demanda) == 0) {
    echo "<script>
            alert('Demanda não encontrada!');
            window.location.href = '../DEMANDAS.php';
          </script>";
    exit;
}

// Primeiro, remove todos os relacionamentos da tabela funcionario_demanda
$sql_delete_rel = "DELETE FROM funcionario_demanda WHERE id_demanda = '$id'";
if (!mysqli_query($conn, $sql_delete_rel)) {
    echo "<script>
            alert('Erro ao remover relacionamentos: " . addslashes(mysqli_error($conn)) . "');
            window.location.href = '../DEMANDAS.php';
          </script>";
    exit;
}

// Depois, exclui a demanda
$sql = "DELETE FROM demandas WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Demanda excluída com sucesso!');
                window.location.href = '../DEMANDAS.php';
              </script>";
    } else {
        echo "<script>
                alert('Nenhuma demanda foi excluída. Verifique o ID.');
                window.location.href = '../DEMANDAS.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Erro ao excluir demanda: " . addslashes(mysqli_error($conn)) . "');
            window.location.href = '../DEMANDAS.php';
          </script>";
}

mysqli_close($conn);
?>