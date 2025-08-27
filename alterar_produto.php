<?php

    session_start();
    require_once 'conexao.php';

    // VERIFICA SE O PRODUTO TEM PERMISSÃO
    if($_SESSION['perfil'] != 1){
        echo "<script>alert('Acesso Negado'); window.location.href='principal.php';</script>";        
        exit();
    }
    
    // INICIALISTA AS VARIAVEIS
    $produto = null;
    
    // SE O FORMULARIO DOR ENCIADO , BUSCAR O PRODUTO PELO ID OU PELO NOME
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if (!empty($_POST['busca_produto'])){
            
            $busca = trim($_POST['busca_produto']);
            // VERIFICA SE A BUSCA É UM (id) OU UM NOME
            if(is_numeric($busca)){
                
                $sql = "SELECT * FROM produto WHERE id_produto = :busca ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
                
            } else {
                
                $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome ";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindValue(":busca_nome","$busca%", PDO::PARAM_STR);
                
            }
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);  

            // SE O PRODUTO NAO FOR ENCONTRADO EXIBE UM ALERTA
            if (!$produto){
                echo "<script>alert('Produto não encontrado!');</script>";        
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="styles.css">
    <!-- CERTIFIQUE QUE O JAVASCRIPT ESTA CARREGADO CORRETAMENTE -->
    <script src="mascara.js"></script>
    <script src="scripts.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>
    <h2>Alterar Produto</h2>

    <form action="alterar_produto.php" method="POST">

    <label for="busca_produto">Digiete o ID ou NOME do Produto (opcional)</label>
    <input type="text" name="busca_produto" id="busca_produto" required onkeyup="buscarSugestoes()">

    <div id="sugestoes">
    </div>

    <button type="submit">Buscar</button>


    </form>

    <?php if ($produto): ?>
        <form action="processa_alteracao_produto.php" method="POST">
            <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produto'])?>" onkeypress="mascara(this, id_produto)">

            <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produto'])?>">
            
            <label for="nome_prod">Nome:</label>
            <input type="text" name="nome_prod" id="nome_prod" value="<?= htmlspecialchars($produto['nome_prod'])?>" required>

            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" id="descricao" value="<?= htmlspecialchars($produto['descricao'])?>" required>

            <label for="qtde">Quantidade:</label>
            <input type="text" name="qtde" id="qtde" value="<?= htmlspecialchars($produto['qtde'])?>" required onkeypress="mascara(this, qtde)">

            <label for="valor_unit">Valor Unitario:</label>
            <input type="text" name="valor_unit" id="valor_unit" value="<?= htmlspecialchars($produto['valor_unit'])?>" required onkeypress="mascara(this, valor_unit)">

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>

        </form>

    <?php endif; ?>


</body>
</html>