<?php
include "../../../validar.php";
include "../../conexao.php";

// Recebe os dados do formulário
$cliente = $_POST['cliente'] ?? '';
$demanda = $_POST['demanda'] ?? '';
$data_demanda = $_POST['data_demanda'] ?? '';
$funcionarios = $_POST['funcionarios'] ?? [];

// Validação básica
if (empty($cliente) || empty($demanda) || empty($data_demanda)) {
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
            alert('Não é permitido cadastrar demandas com datas passadas!');
            window.history.back();
          </script>";
    exit;
}

// Sanitiza os dados
$cliente = mysqli_real_escape_string($conn, $cliente);
$demanda = mysqli_real_escape_string($conn, trim($demanda));
$data_demanda = mysqli_real_escape_string($conn, $data_demanda);

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

// Insere a demanda no banco de dados
$sql = "INSERT INTO demandas (cliente, demanda, data_demanda) 
        VALUES ('$cliente', '$demanda', '$data_demanda')";

if (mysqli_query($conn, $sql)) {
    // Pega o ID da demanda recém criada
    $demanda_id = mysqli_insert_id($conn);
    
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
                            VALUES ('$func_id', '$demanda_id')";
                
                if (!mysqli_query($conn, $sql_func)) {
                    $sucesso_funcionarios = false;
                }
            }
        }
        
        if ($sucesso_funcionarios) {
            $total_func = count($funcionarios);
            echo "<script>
                    alert('Demanda cadastrada com sucesso com $total_func funcionário(s) destacado(s)!');
                    window.location.href = '../DEMANDAS.PHP';
                  </script>";
        } else {
            echo "<script>
                    alert('Demanda cadastrada, mas houve erro ao destacar alguns funcionários.');
                    window.location.href = '../DEMANDAS.PHP';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Demanda cadastrada com sucesso!');
                window.location.href = '../DEMANDAS.PHP';
              </script>";
    }
} else {
    echo "<script>
            alert('Erro ao cadastrar demanda: " . mysqli_error($conn) . "');
            window.history.back();
          </script>";
}

mysqli_close($conn);
?>