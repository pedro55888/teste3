<?php
// Configurações do banco de dados (SUBSTITUA COM SEUS DADOS!)
$host = "localhost";
$usuario = "root";
$senha = "123456";
$banco = "banco";

$conexao = new mysqli($host, $usuario, $senha, $banco);
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"]; // SENHA ARMAZENADA EM TEXTO PLANO - NÃO FAÇA ISSO EM UM SITE REAL!

    if (empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }

    $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("Email já cadastrado.");
    }
    $stmt->close();

    $stmt = $conexao->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $senha); // SENHA ARMAZENADA EM TEXTO PLANO
    if ($stmt->execute()) {
        echo "Cadastro realizado!";
        header("Location: painel.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }
    $stmt->close();
}
$conexao->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Site</title>
</head>
<body>

<form action="" method="POST">
<div id="cadastro">
<div class="caixa">

<H1>Crie Sua Conta Aqui</H1>

<div class="email">
<p>
    <input type="text" name="email" placeholder="Coloque Seu Melhor E-mail">
</p>

</div>


<div class="senha">
<p>   
    <input type="text" name="senha" placeholder="Coloque Sua Senha">
    </p>
</div>

<div class="repitaasenha">
<p>   
    <input type="text" name="senha" placeholder="Confirme a Senha">
    </p>
</div>

<div class="entrar">
    <p>
        <input type="submit" value="Criar Conta">
        


        <p>Já tem uma Conta? <a href="index.php">Faça Login</a></p>
    </p>
</div>

</div>

