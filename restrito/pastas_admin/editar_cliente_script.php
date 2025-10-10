<?php
include "../../validar.php";
include "../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $telefone = mysqli_real_escape_string($conn, trim($_POST['telefone']));
    $cep = mysqli_real_escape_string($conn, trim($_POST['cep']));
    $numero_casa = isset($_POST['numero_casa']) ? (int)$_POST['numero_casa'] : NULL;
    $complemento = isset($_POST['complemento']) ? mysqli_real_escape_string($conn, trim($_POST['complemento'])) : NULL;
    
    // Validações básicas
    if (strlen($telefone) != 11) {
        header("Location: editar_cliente.php?id=$id&msg=Telefone deve ter 11 dígitos");
        exit;
    }
    
    if (strlen($cep) != 8) {
        header("Location: editar_cliente.php?id=$id&msg=CEP deve ter 8 dígitos");
        exit;
    }
    
    $sql = "UPDATE cliente SET 
            nome = '$nome', 
            email = '$email', 
            telefone = '$telefone', 
            cep = '$cep', 
            numero_casa = " . ($numero_casa ? "$numero_casa" : "NULL") . ", 
            complemento = " . ($complemento ? "'$complemento'" : "NULL") . "
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: CLIENTES.PHP?msg=Cliente atualizado com sucesso");
    } else {
        header("Location: editar_cliente.php?id=$id&msg=Erro ao atualizar cliente");
    }
} else {
    header("Location: CLIENTES.PHP");
}
exit;
?>
