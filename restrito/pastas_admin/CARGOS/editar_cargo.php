<?php
include "../../../validar.php";
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
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

    // Verificar se o cargo existe
    $verifica = "SELECT funcao, salario FROM cargos WHERE id = $id";
    $result = mysqli_query($conn, $verifica);
    
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Cargo não encontrado!'); window.location.href = 'gerenciar_cargos.php';</script>";
        exit;
    }

    $cargo_antigo = mysqli_fetch_assoc($result);

    // Verificar se já existe outro cargo com o mesmo nome
    $verifica_duplicado = "SELECT id FROM cargos WHERE LOWER(funcao) = LOWER('$funcao') AND id != $id";
    $result_duplicado = mysqli_query($conn, $verifica_duplicado);
    
    if (mysqli_num_rows($result_duplicado) > 0) {
        echo "<script>alert('Já existe outro cargo com esta função cadastrada!'); history.back();</script>";
        exit;
    }

    // Atualizar cargo
    $sql = "UPDATE cargos SET funcao = '$funcao', salario = $salario WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Verificar quantos funcionários foram afetados
        $sql_count = "SELECT COUNT(*) as total FROM funcionarios WHERE cargo = $id";
        $result_count = mysqli_query($conn, $sql_count);
        $count = mysqli_fetch_assoc($result_count);

        $mensagem = "Cargo atualizado com sucesso!\\n\\n";
        $mensagem .= "Função: {$cargo_antigo['funcao']} → $funcao\\n";
        $mensagem .= "Salário: R$ " . number_format($cargo_antigo['salario'], 2, ',', '.') . " → R$ " . number_format($salario, 2, ',', '.') . "\\n";
        
        if ($count['total'] > 0) {
            $mensagem .= "\\n{$count['total']} funcionário(s) afetado(s) por esta alteração.";
        }

        echo "<script>
                alert('$mensagem');
                window.location.href = 'gerenciar_cargos.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao atualizar cargo: " . mysqli_error($conn) . "');
                history.back();
              </script>";
    }
} else {
    header("Location: gerenciar_cargos.php");
}
?>