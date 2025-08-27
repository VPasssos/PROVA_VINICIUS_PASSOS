<?php
    
session_start();
require_once 'conexao.php';

if($_SESSION['perfil'] != 1){
    echo "<script> alert('Acesso Negado!'); window.location.href='principal.php' </script>";
    exit();
}
// INCIALIZA A VARIAVEL PARA EVITAR ERROS 
$produto = [];

// BUSCA TODOS OS PRODUTOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM produto ORDER BY nome_prod ASC";
$stmt = $pdo->prepare($sql);
$stmt-> execute();
$produtos = $stmt-> fetchAll(PDO::FETCH_ASSOC);

// SE UM ID FOR PASSADO VAI GET, EXCLUIR PRODUTO

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_produto = $_GET['id'];

    // EXCLUI O PRODUTO DO BUNCO DE DADOS
    $sql = "DELETE FROM produto WHERE id_produto = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);

    if ($stmt->execute()){
        echo "<script> alert('Usuario Excluido com Suceso!'); window.location.href='excluir_produto.php'; </script>";
    } else{
        echo "<script> alert('Erro ao Excluir produto!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'menu.php'; ?>
    <h2>Excluir Usuario</h2>

    <?php if(!empty($produtos)):?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Descricao</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Valor Unitario</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($produtos as $produto):?>
                <tr>
                    <td><?=htmlspecialchars($produto['id_produto'])?></td>
                    <td><?=htmlspecialchars($produto['nome_prod'])?></td>
                    <td><?=htmlspecialchars($produto['descricao'])?></td>
                    <td><?=htmlspecialchars($produto['qtde'])?></td>
                    <td><?=htmlspecialchars($produto['valor_unit'])?></td>
                    <td>
                        <a href="excluir_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>"onclick="return confirm('Tem certeza que deseja excluir esse produto')">Excluir</a>
                    </td>
                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else:?>
            <p>Nenhum produto encontrado</p>
            <?php endif; ?>

</body>
</html>