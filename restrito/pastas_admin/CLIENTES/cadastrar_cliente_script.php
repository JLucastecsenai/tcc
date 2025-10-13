<?php
include "../../../validar.php";
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $telefone = mysqli_real_escape_string($conn, trim($_POST['telefone']));
    $cpf = mysqli_real_escape_string($conn, trim($_POST['cpf']));
    $cep = mysqli_real_escape_string($conn, trim($_POST['cep']));
    $numero_casa = isset($_POST['numero_casa']) ? (int)$_POST['numero_casa'] : NULL;
    $complemento = isset($_POST['complemento']) ? mysqli_real_escape_string($conn, trim($_POST['complemento'])) : NULL;
    
    // Validações básicas
    if (strlen($telefone) != 11) {
        header("Location: cadastrar_cliente.php?msg=Telefone deve ter 11 dígitos");
        exit;
    }
    
    if (strlen($cpf) != 11) {
        header("Location: cadastrar_cliente.php?msg=CPF deve ter 11 dígitos");
        exit;
    }
    
    if (strlen($cep) != 8) {
        header("Location: cadastrar_cliente.php?msg=CEP deve ter 8 dígitos");
        exit;
    }
    
    // Verifica se CPF já existe
    $check_cpf = mysqli_query($conn, "SELECT id FROM cliente WHERE cpf = '$cpf'");
    if (mysqli_num_rows($check_cpf) > 0) {
        header("Location: cadastrar_cliente.php?msg=CPF já cadastrado no sistema");
        exit;
    }
    
    $sql = "INSERT INTO cliente (nome, email, telefone, cpf, cep, numero_casa, complemento) 
            VALUES ('$nome', '$email', '$telefone', '$cpf', '$cep', " . 
            ($numero_casa ? "$numero_casa" : "NULL") . ", " . 
            ($complemento ? "'$complemento'" : "NULL") . ")";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../CLIENTES.PHP?msg=Cliente cadastrado com sucesso");
    } else {
        header("Location: cadastrar_cliente.php?msg=Erro ao cadastrar cliente");
    }
} else {
    header("Location: ../CLIENTES.PHP");
}
exit;
?>