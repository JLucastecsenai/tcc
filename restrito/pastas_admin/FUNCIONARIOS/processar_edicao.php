<?php
include "../../../validar.php";
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone = mysqli_real_escape_string($conn, preg_replace('/\D/', '', $_POST['telefone']));
    $cpf = mysqli_real_escape_string($conn, preg_replace('/\D/', '', $_POST['cpf']));
    $cargo = (int)$_POST['cargo'];

    // Validações
    if (strlen($telefone) != 11) {
        echo "<script>alert('Telefone deve ter 11 dígitos!'); history.back();</script>";
        exit;
    }

    if (strlen($cpf) != 11) {
        echo "<script>alert('CPF deve ter 11 dígitos!'); history.back();</script>";
        exit;
    }

    // Verificar se CPF já existe em outro funcionário
    $verifica_cpf = "SELECT id FROM funcionarios WHERE cpf = '$cpf' AND id != $id";
    $result_cpf = mysqli_query($conn, $verifica_cpf);
    if (mysqli_num_rows($result_cpf) > 0) {
        echo "<script>alert('CPF já cadastrado para outro funcionário!'); history.back();</script>";
        exit;
    }

    // Atualizar funcionário
    $sql = "UPDATE funcionarios 
            SET nome = '$nome', 
                email = '$email', 
                telefone = '$telefone', 
                cpf = '$cpf', 
                cargo = $cargo
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Funcionário atualizado com sucesso!');
                window.location.href = '../FUNCIONARIOS.PHP';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao atualizar funcionário: " . mysqli_error($conn) . "');
                history.back();
              </script>";
    }
} else {
    header("Location: ../FUNCIONARIOS.PHP");
}
?>