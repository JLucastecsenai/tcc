<?php
include "../../../validar.php";
include "../../conexao.php";

// Recebe os dados do formulário
$id = $_POST['id'] ?? '';
$cliente = $_POST['cliente'] ?? '';
$demanda = $_POST['demanda'] ?? '';
$data_demanda = $_POST['data_demanda'] ?? '';
$funcionarios = $_POST['funcionarios'] ?? [];

// Validação básica
if (empty($id) || empty($cliente) || empty($demanda) || empty($data_demanda)) {
    echo "<script>
            alert('Todos os campos obrigatórios devem ser preenchidos!');
            window.history.back();
          </script>";
    exit;
}

// Validação de data: não permite datas passadas
$hoje = date('Y-m-d');
if ($data_demanda < $hoje) {
    echo "<script>
            alert('Não é permitido definir datas passadas para a demanda!');
            window.history.back();
          </script>";
    exit;
}

// Sanitiza os dados
$id = mysqli_real_escape_string($conn, $id);
$cliente = mysqli_real_escape_string($conn, $cliente);
$demanda = mysqli_real_escape_string($conn, trim($demanda));
$data_demanda = mysqli_real_escape_string($conn, $data_demanda);

// Valida se a demanda existe
$sql_check_demanda = "SELECT id FROM demandas WHERE id = '$id'";
$result_check_demanda = mysqli_query($conn, $sql_check_demanda);

if (mysqli_num_rows($result_check_demanda) == 0) {
    echo "<script>
            alert('Demanda não encontrada!');
            window.location.href = '../DEMANDAS.php';
          </script>";
    exit;
}

// Valida se o cliente existe
$sql_check = "SELECT id FROM cliente WHERE id = '$cliente'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) == 0) {
    echo "<script>
            alert('Cliente não encontrado!');
            window.history.back();
          </script>";
    exit;
}

// Atualiza a demanda no banco de dados
$sql = "UPDATE demandas 
        SET cliente = '$cliente', 
            demanda = '$demanda', 
            data_demanda = '$data_demanda' 
        WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    // Remove todos os funcionários anteriores desta demanda
    $sql_delete = "DELETE FROM funcionario_demanda WHERE id_demanda = '$id'";
    mysqli_query($conn, $sql_delete);
    
    // Se funcionários foram selecionados, adiciona na tabela funcionario_demanda
    if (!empty($funcionarios)) {
        $sucesso_funcionarios = true;
        foreach ($funcionarios as $func_id) {
            $func_id = mysqli_real_escape_string($conn, $func_id);
            
            // Verifica se o funcionário existe
            $sql_check_func = "SELECT id FROM funcionarios WHERE id = '$func_id'";
            $result_check_func = mysqli_query($conn, $sql_check_func);
            
            if (mysqli_num_rows($result_check_func) > 0) {
                $sql_func = "INSERT INTO funcionario_demanda (id_funcionarios, id_demanda) 
                            VALUES ('$func_id', '$id')";
                
                if (!mysqli_query($conn, $sql_func)) {
                    $sucesso_funcionarios = false;
                }
            }
        }
        
        if ($sucesso_funcionarios) {
            $total_func = count($funcionarios);
            echo "<script>
                    alert('Demanda atualizada com sucesso com $total_func funcionário(s) destacado(s)!');
                    window.location.href = '../DEMANDAS.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Demanda atualizada, mas houve erro ao destacar alguns funcionários.');
                    window.location.href = '../DEMANDAS.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Demanda atualizada com sucesso!');
                window.location.href = '../DEMANDAS.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Erro ao atualizar demanda: " . mysqli_error($conn) . "');
            window.history.back();
          </script>";
}

mysqli_close($conn);
?>