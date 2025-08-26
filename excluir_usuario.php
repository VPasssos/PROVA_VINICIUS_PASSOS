<?php
    
session_start();
require_once 'conexao.php';

if($_SESSION['perfil'] != 1){
    echo "<script> alert('Acesso Negado!'); window.location.href='principal.php' </script>";
    exit();
}
// INCIALIZA A VARIAVEL PARA EVITAR ERROS 
$usuario = [];

// BUSCA TODOS OS USUARIOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt-> execute();
$usuarios = $stmt-> fetchAll(PDO::FETCH_ASSOC);

// SE UM ID FOR PASSADO VAI GET, EXCLUIR USUARIO

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    // EXCLUI O USUARIO DO BUNCO DE DADOS
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()){
        echo "<script> alert('Usuario Excluido com Suceso!'); window.location.href='excluir_usuario.php'; </script>";
    } else{
        echo "<script> alert('Erro ao Excluir usuario!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <h2>Excluir Usuario</h2>

    <?php if(!empty($usuarios)):?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Perfil</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $usuario):?>
                <tr>
                    <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                    <td><?=htmlspecialchars($usuario['nome'])?></td>
                    <td><?=htmlspecialchars($usuario['email'])?></td>
                    <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                    <td>
                        <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>"onclick="return confirm('Tem certeza que deseja excluir esse usuario')">Excluir</a>
                    </td>
                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else:?>
            <p>Nenhum usuario encontrado</p>
            <?php endif; ?>

</body>
</html>