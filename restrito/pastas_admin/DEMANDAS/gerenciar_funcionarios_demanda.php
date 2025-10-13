<?php
include "../../../validar.php";
include "../../conexao.php";

// Recebe os dados do formulário
$demanda_id = $_POST['demanda_id'] ?? '';
$funcionarios = $_POST['funcionarios'] ?? [];

// Validação
if (empty($demanda_id) || !is_numeric($demanda_id)) {
    echo "<script>
            alert('ID da demanda inválido!');
            window.location.href = '../DEMANDAS.php';
          </script>";
    exit;
}

$demanda_id = mysqli_real_escape_string($conn, $demanda_id);

// Verifica se a demanda existe
$sql_check = "SELECT id FROM demandas WHERE id = '$demanda_id'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) == 0) {
    echo "<script>
            alert('Demanda não encontrada!');
            window.location.href = '../DEMANDAS.php';
          </script>";
    exit;
}

// Remove todos os funcionários anteriores desta demanda
$sql_delete = "DELETE FROM funcionario_demanda WHERE id_demanda = '$demanda_id'";
mysqli_query($conn, $sql_delete);

// Insere os novos funcionários selecionados
$sucesso = true;
if (!empty($funcionarios)) {
    foreach ($funcionarios as $func_id) {
        $func_id = mysqli_real_escape_string($conn, $func_id);
        
        // Verifica se o funcionário existe
        $sql_check_func = "SELECT id FROM funcionarios WHERE id = '$func_id'";
        $result_check_func = mysqli_query($conn, $sql_check_func);
        
        if (mysqli_num_rows($result_check_func) > 0) {
            $sql_insert = "INSERT INTO funcionario_demanda (id_funcionarios, id_demanda) 
                          VALUES ('$func_id', '$demanda_id')";
            
            if (!mysqli_query($conn, $sql_insert)) {
                $sucesso = false;
                break;
            }
        }
    }
}

if ($sucesso) {
    $total_funcionarios = count($funcionarios);
    $mensagem = $total_funcionarios > 0 
        ? "Funcionários atualizados com sucesso! Total: $total_funcionarios" 
        : "Todos os funcionários foram removidos desta demanda.";
    
    echo "<script>
            alert('$mensagem');
            window.location.href = '../DEMANDAS.php';
          </script>";
} else {
    echo "<script>
            alert('Erro ao atualizar funcionários: " . mysqli_error($conn) . "');
            window.location.href = '../DEMANDAS.php';
          </script>";
}

mysqli_close($conn);
?>