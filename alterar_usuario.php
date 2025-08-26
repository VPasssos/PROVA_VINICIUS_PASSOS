<?php

    session_start();
    require_once 'conexao.php';

    // VERIFICA SE O USUARIO TEM PERMISSÃO
    if($_SESSION['perfil'] != 1){
        echo "<script>alert('Acesso Negado'); window.location.href='principal.php';</script>";        
        exit();
    }
    
    // INICIALISTA AS VARIAVEIS
    $usuario = null;
    
    // SE O FORMULARIO DOR ENCIADO , BUSCAR O USUARIO PELO ID OU PELO NOME
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if (!empty($_POST['busca_usuario'])){
            
            $busca = trim($_POST['busca_usuario']);
            // VERIFICA SE A BUSCA É UM (id) OU UM NOME
            if(is_numeric($busca)){
                
                $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
                
            } else {
                
                $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindValue(":busca_nome","$busca%", PDO::PARAM_STR);
                
            }
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);  

            // SE O USUARIO NAO FOR ENCONTRADO EXIBE UM ALERTA
            if (!$usuario){
                echo "<script>alert('Usuario não encontrado!');</script>";        
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <!-- CERTIFIQUE QUE O JAVASCRIPT ESTA CARREGADO CORRETAMENTE -->
    <script src="scripts.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>
    <h2>Alterar Usuario</h2>

    <form action="alterar_usuario.php" method="POST">

    <label for="busca_usuario">Digiete o ID ou NOME do Usuario (opcional)</label>
    <input type="text" name="busca_usuario" id="busca_usuario" required onkeyup="buscarSugestoes()">

    <div id="sugestoes">
    </div>

    <button type="submit">Buscar</button>


    </form>

    <?php if ($usuario): ?>
        <form action="processa_alteracao_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario'])?>">

            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario'])?>">
            
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome'])?>" required>


            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email'])?>" required>


            <label for="id_perfil">Perfil:</label>
            <select name="id_perfil" id="id_perfil">

                <option value="1" <?= $usuario['id_perfil'] == 1 ? 'selected' : '' ?>>Administrador</option>
                <option value="2" <?= $usuario['id_perfil'] == 2 ? 'selected' : ''?>>Secretária</option>
                <option value="3" <?= $usuario['id_perfil'] == 3 ? 'selected' : ''?>>Almoxarife</option>
                <option value="4" <?= $usuario['id_perfil'] == 4 ? 'selected' : ''?>>Cliente</option>

            </select>
            
            <!-- SE O USUARIO LOGADO FOR ADM, EXIBIR OP DE ALTERAR SENHA -->

            <?php if($_SESSION['perfil'] == '1'):?>

            <label for="nova_senha">Nova senha:</label>
            <input type="password" name="nova_senha" id="nova_senha">
            <?php endif; ?>

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>

        </form>

    <?php endif; ?>


</body>
</html>