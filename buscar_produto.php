<?php
    
session_start();
require_once 'conexao.php';

if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] !=2){
    echo "<script> alert('Acesso Negado!'); window.location.href='principal.php' </script>";
    exit();
}
// INCIALIZA A VARIAVEL PARA EVITAR ERROS 
$produtos = [];

// SE O FORMULARIO FOR ENCIADO, BISCA O PRODUTO PELO ID OU NOME
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){

    $busca = trim($_POST['busca']);
    // VERIFICA SE A BUSCA É UM (id) OU UM NOME
    if(is_numeric($busca)){

        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);

    } else {

        $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome ORDER BY nome_prod ASC";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindValue(":busca_nome","$busca%", PDO::PARAM_STR);

    }

}else{
    $sql = "SELECT * FROM produto ORDER BY nome_prod ASC";
    $stmt = $pdo -> prepare($sql);
}

$stmt->execute();
$produtos = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Produto</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'menu.php'; ?>   
    <h2>Lista de Usuarios</h2>
    <!-- FORMULARIO PARA BUSCAR PRODUTO  -->
    <form action="buscar_produto.php" method="POST">

    <label for="busca">Digiete o ID ou NOME  (opcional)</label>
    <input type="text" name="busca" id="busca">
    <button type="submit">Pesquisar</button>

    </form>
    <div class = "table_buscar">
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
                            <a href="alterar_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>">Alterar</a>
                            <a href="excluir_produto.php?id=<?=htmlspecialchars($produto['id_produto'])?>"onclick="return confirm('Tem certeza que deseja excluir esse produto')">Excluir</a>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else:?>
                <p>Nenhum produto encontrado</p>
                <?php endif; ?>
    </div>
                

</body>
</html>