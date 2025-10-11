<?php
include "../../../validar.php";
include "../../conexao.php";

$id = (int)$_GET['id'];

// Verificar se o funcionário existe
$verifica = "SELECT nome FROM funcionarios WHERE id = $id";
$result = mysqli_query($conn, $verifica);

if (mysqli_num_rows($result) == 0) {
    echo "<script>
            alert('Funcionário não encontrado!');
            window.location.href = '../FUNCIONARIOS.PHP';
          </script>";
    exit;
}

$funcionario = mysqli_fetch_assoc($result);

// Verificar se o funcionário está vinculado a alguma demanda
$verifica_demandas = "SELECT COUNT(*) as total FROM funcionario_demanda WHERE id_funcionarios = $id";
$result_demandas = mysqli_query($conn, $verifica_demandas);
$demandas = mysqli_fetch_assoc($result_demandas);

if ($demandas['total'] > 0) {
    echo "<script>
            alert('Não é possível excluir este funcionário pois ele está vinculado a " . $demandas['total'] . " demanda(s)!\\nRemova os vínculos antes de excluir.');
            window.location.href = '../FUNCIONARIOS.PHP';
          </script>";
    exit;
}

// Verificar se é um admin
$verifica_admin = "SELECT COUNT(*) as total FROM admin_login WHERE funcionario_admin = $id";
$result_admin = mysqli_query($conn, $verifica_admin);
$admin = mysqli_fetch_assoc($result_admin);

if ($admin['total'] > 0) {
    echo "<script>
            alert('Não é possível excluir este funcionário pois ele é um administrador do sistema!');
            window.location.href = '../FUNCIONARIOS.PHP';
          </script>";
    exit;
}

// Excluir funcionário
$sql = "DELETE FROM funcionarios WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Funcionário " . $funcionario['nome'] . " excluído com sucesso!');
            window.location.href = '../FUNCIONARIOS.PHP';
          </script>";
} else {
    echo "<script>
            alert('Erro ao excluir funcionário: " . mysqli_error($conn) . "');
            window.location.href = '../FUNCIONARIOS.PHP';
          </script>";
}
?>