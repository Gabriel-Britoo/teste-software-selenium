<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro_login.css">
    <title>Entrar</title>
</head>
<body>
    <section class="section-form">
        <form action="" method="POST">
            <h1>Entrar na conta</h1>

            <label for="email">Email</label>
            <input type="text" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" required>

            <?php
            session_start();
            include 'conexao.php';

            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $senha = $_POST["senha"];

                $query = "SELECT * FROM usuarios WHERE email = '$email'";

                $result = mysqli_query($conexao, $query);

                if($result->num_rows > 0) {
                    $usuario = $result->fetch_assoc();

                    if (password_verify($senha, $usuario['senha'])){
                        $_SESSION['usuario'] = $usuario;

                        header('Location: dashboard.php');
                    } else {
                        echo "<p style='color:red;'>Senha incorreta</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Email incorreto</p>";
                }
            }
            ?>

            <button type="submit">Entrar</button>

            <p>Não possui uma conta? <a href="cadastro.php">Comece agora!</a></p>
        </form>
    </section>
</body>
</html>