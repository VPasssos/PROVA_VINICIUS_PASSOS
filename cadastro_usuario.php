<?php

session_start();
require_once 'conexao.php';

// VERIFICA A PERMIÇÂO DO USUARIO
// SUPANDO QUE O PERFIL 1 SEJA 0 ADM 
if($_SESSION['perfil']!=1){
    echo "Acesso Negado";
    exit();
};

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $nome =$_POST['nome'];
    $email = $_POST['email'];
    $senha = password($_POST['senha'],PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];

    $sql = "INSERT INTO usuario(nome, email, senha, id_perfil) VALUES(:nome, :email, :senha, :id_perfil)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome",$nome);
    $stmt->bindParam(":email",$email);
    $stmt->bindParam(":senha",$senha);
    $stmt->bindParam(":id_perfil",$id_perfil);
    if ($stmt->execute()){}
}