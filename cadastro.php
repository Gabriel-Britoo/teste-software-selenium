<?php
include 'conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql_verifica = "SELECT * FROM usuarios WHERE email = ?";
    $stmt_verifica = $conexao->prepare($sql_verifica);
    $stmt_verifica->bind_param("s", $email);
    $stmt_verifica->execute();
    $resultado = $stmt_verifica->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION['mensagem_erro'] = "Este e-mail já está cadastrado.";
        echo "<script>
            alert('" . $_SESSION['mensagem_erro'] . "');
            window.location.href = 'cadastro.php';
            </script>";
    } else {
        if (strlen($senha) >= 8) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql_insercao = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conexao->prepare($sql_insercao);
            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {
                $_SESSION['mensagem_cadastro'] = "Cadastro bem-sucedido!";
                echo "<script>
                    alert('" . $_SESSION['mensagem_cadastro'] . "');
                    window.location.href = 'index.php';
                    </script>";
            } else {
                echo "Erro ao cadastrar usuário: " . $conexao->error;
            }

            $stmt->close();
        } else {
            $_SESSION['mensagem_senha'] = "Senha muito curta! Deve ter pelo menos 8 caracteres.";
            echo "<script>
                alert('" . $_SESSION['mensagem_senha'] . "');
                </script>";
        }
    }

    $stmt_verifica->close();
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
            <input type="email" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" required>

            <button type="submit">Cadastrar</button>

            <p>Já possui uma conta? <a href="index.php">Entre!</a></p>
        </form>
    </section>
</body>

</html>