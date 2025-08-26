<?php
    session_start();


    require_once 'conexao.php';


    // VERIFICA SE O USUARIO TEM PERMISSÃO
    // SUPONDO QUE O PERFIL '1' SEJA O 'ADM'
    if($_SESSION['perfil'] != 1){
        echo "Acesso negado!";
        exit();
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome_prod = $_POST['nome_prod'];
        $descricao = $_POST['descricao'];
        $qtde = $_POST['qtde'];
        $valor_unit = $_POST['valor_unit'];
       
        $query = "INSERT INTO produto (nome_prod, descricao, qtde, valor_unit) VALUES (:nome_prod, :descricao, :qtde, :valor_unit)";


        $stmt = $pdo -> prepare($query);


        $stmt -> bindParam(":nome_prod", $nome_prod);
        $stmt -> bindParam(":descricao", $descricao);
        $stmt -> bindParam(":qtde", $qtde);
        $stmt -> bindParam(":valor_unit", $valor_unit);


        if ($stmt -> execute()) {
            echo "<script> alert('Produto cadastrado com sucesso!'); </script>";
        } else {
            echo "<script> alert('Erro ao cadastrar o Produto!'); </script>";
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Produto</title>


    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'menu.php'; ?>   
    <h2>Cadastro Produto</h2>


    <form action="cadastro_produto.php" method="POST">
        <label for="nome_prod">Nome:</label>
        <input type="text" name="nome_prod" id="nome_prod" required>


        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" required>


        <label for="qtde">Quantidade:</label>
        <input type="text" name="qtde" id="qtde" required>
      
        <label for="valor_unit">Valor Unitario:</label>
        <input type="text" name="valor_unit" id="valor_unit" required>

        <button type="submit">Cadastrar</button>
        <button type="reset">Cancelar</button>
    </form>



<script src="validacoes.js"></script>
</body>
</html>



