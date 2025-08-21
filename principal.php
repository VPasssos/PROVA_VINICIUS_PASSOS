<?php

session_start();
require_once 'conexao.php';

// GARANTE QUE O USUARIO ESTEJA LOGADO
if(!isset($_SESSION['usuario'])){

    header("Location: login.php");
    exit();
}

// OBTENDO O NOME DO PERFIL DO USUARIO LOGADO

$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(":id_perfil",$id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil["nome_perfil"];

?>

<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    
    <header>

    <div class="saudacao">
        <h2>Bem vindo, <?php echo $_SESSION['usuario']; ?>! Perfil: <?php echo $nome_perfil ?></h2>
    </div>

    </header>

    <?php include 'menu.php'; ?>

</body>
</html>