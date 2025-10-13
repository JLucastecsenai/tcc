<?php
include "../../../validar.php";
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $funcao = mysqli_real_escape_string($conn, trim($_POST['funcao']));
    $salario = floatval($_POST['salario']);

    // Validações
    if (empty($funcao)) {
        echo "<script>alert('O nome da função é obrigatório!'); history.back();</script>";
        exit;
    }

    if ($salario < 0) {
        echo "<script>alert('O salário não pode ser negativo!'); history.back();</script>";
        exit;
    }

    // Verificar se já existe um cargo com o mesmo nome
    $verifica = "SELECT id FROM cargos WHERE LOWER(funcao) = LOWER('$funcao')";
    $result = mysqli_query($conn, $verifica);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Já existe um cargo com esta função cadastrada!'); history.back();</script>";
        exit;
    }

    // Inserir novo cargo
    $sql = "INSERT INTO cargos (funcao, salario) VALUES ('$funcao', $salario)";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Cargo cadastrado com sucesso!\\n\\nFunção: $funcao\\nSalário: R$ " . number_format($salario, 2, ',', '.') . "');
                window.location.href = 'gerenciar_cargos.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar cargo: " . mysqli_error($conn) . "');
                history.back();
              </script>";
    }
} else {
    header("Location: gerenciar_cargos.php");
}
?>