<?php
include "../../../validar.php";
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_funcionario = (int)$_POST['id_funcionario'];
    $novo_cargo = (int)$_POST['novo_cargo'];

    // Buscar nome do funcionário e do cargo
    $sql_info = "SELECT f.nome, c.funcao 
                 FROM funcionarios f
                 LEFT JOIN cargos c ON f.cargo = c.id
                 WHERE f.id = $id_funcionario";
    $result_info = mysqli_query($conn, $sql_info);
    
    if (mysqli_num_rows($result_info) == 0) {
        echo "<script>alert('Funcionário não encontrado!'); window.location.href = '../FUNCIONARIOS.PHP';</script>";
        exit;
    }

    $info = mysqli_fetch_assoc($result_info);
    $cargo_antigo = $info['funcao'];

    // Buscar nome do novo cargo
    $sql_cargo = "SELECT funcao FROM cargos WHERE id = $novo_cargo";
    $result_cargo = mysqli_query($conn, $sql_cargo);
    $novo_cargo_info = mysqli_fetch_assoc($result_cargo);

    // Atualizar cargo do funcionário
    $sql = "UPDATE funcionarios SET cargo = $novo_cargo WHERE id = $id_funcionario";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Cargo alterado com sucesso!\\n\\nFuncionário: {$info['nome']}\\nCargo Anterior: $cargo_antigo\\nNovo Cargo: {$novo_cargo_info['funcao']}');
                window.location.href = '../FUNCIONARIOS.PHP';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao alterar cargo: " . mysqli_error($conn) . "');
                window.location.href = '../FUNCIONARIOS.PHP';
              </script>";
    }
} else {
    header("Location: ../FUNCIONARIOS.PHP");
}
?>