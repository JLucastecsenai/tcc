<?php 
session_start();

// Verifica se as variáveis de sessão existem (usando as mesmas do admin.php)
if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_login']) && isset($_SESSION['loggedin'])) {
    $user_id = $_SESSION['usuario_id'];
    $user_login = $_SESSION['usuario_login'];
    
} else {
    session_destroy();
    header("location: admin.php?msg=Faça login para acessar");
    exit();
}

?>