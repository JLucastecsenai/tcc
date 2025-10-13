<?php
include "../../../validar.php";
include "../../conexao.php";

$id = (int)$_GET['id'];

// Verificar se o cargo existe
$verifica = "SELECT funcao, salario FROM cargos WHERE id = $id";
$result = mysqli_query($conn, $verifica);

if (mysqli_num_rows($result) == 0) {
    echo "<script>
            alert('Cargo não encontrado!');
            window.location.href = 'gerenciar_cargos.php';
          </script>";
    exit;
}

$cargo = mysqli_fetch_assoc($result);

// Verificar se há funcionários com este cargo
$verifica_funcionarios = "SELECT COUNT(*) as total FROM funcionarios WHERE cargo = $id";
$result_funcionarios = mysqli_query($conn, $verifica_funcionarios);
$funcionarios = mysqli_fetch_assoc($result_funcionarios);

if ($funcionarios['total'] > 0) {
    echo "<script>
            alert('Não é possível excluir este cargo!\\n\\nExistem {$funcionarios['total']} funcionário(s) vinculado(s) a este cargo.\\nAltere o cargo dos funcionários antes de excluir.');
            window.location.href = 'gerenciar_cargos.php';
          </script>";
    exit;
}

// Excluir cargo
$sql = "DELETE FROM cargos WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Cargo \"{$cargo['funcao']}\" excluído com sucesso!');
            window.location.href = 'gerenciar_cargos.php';
          </script>";
} else {
    echo "<script>
            alert('Erro ao excluir cargo: " . mysqli_error($conn) . "');
            window.location.href = 'gerenciar_cargos.php';
          </script>";
}
?>