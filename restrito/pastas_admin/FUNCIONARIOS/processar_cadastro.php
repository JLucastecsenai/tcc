<?php
include "../../../validar.php";
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Verificar se CPF já existe
    $verifica_cpf = "SELECT id FROM funcionarios WHERE cpf = '$cpf'";
    $result_cpf = mysqli_query($conn, $verifica_cpf);
    if (mysqli_num_rows($result_cpf) > 0) {
        echo "<script>alert('CPF já cadastrado no sistema!'); history.back();</script>";
        exit;
    }

    // Inserir funcionário
    $sql = "INSERT INTO funcionarios (nome, email, telefone, cpf, cargo) 
            VALUES ('$nome', '$email', '$telefone', '$cpf', $cargo)";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Funcionário cadastrado com sucesso!');
                window.location.href = '../FUNCIONARIOS.PHP';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar funcionário: " . mysqli_error($conn) . "');
                history.back();
              </script>";
    }
} else {
    header("Location: ../FUNCIONARIOS.PHP");
}
?>