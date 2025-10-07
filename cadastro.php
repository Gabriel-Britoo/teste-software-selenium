<?php
include 'conexao.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql_insercao = "INSERT usuarios (nome, email, senha) VALUES (?,?,?)";

    $stmt = $conexao->prepare($sql_insercao);

    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if($stmt->execute()){
        header("Location: dashboard.php");
    } else {
        echo "Erro ao cadastrar usuário: ".$conexao->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro_login.css">
    <title>Cadastrar</title>
</head>
<body>
    <section class="section-form">
        <form action="" method="POST">
            <h1>Criar conta</h1>

            <label for="nome">Nome</label>
            <input type="text" name="nome" required>

            <label for="email">Email</label>
            <input type="text" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" required>

            <button type="submit">Cadastrar</button>

            <p>Já possui uma conta? <a href="index.php">Entre agora!</a></p>
        </form>
    </section>
</body>
</html>