<<?php
session_start();
include 'db_connect.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        // Prepara a consulta PDO
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comparação simples (sem password_verify)
        if ($user && $senha === $user['senha']) {
            $_SESSION['admin'] = ($user['admin'] == 1);
            $_SESSION['usuario'] = $user['nome'];
            header("Location: upload_news.php");
            exit;
        } else {
            $error = "E-mail ou senha incorretos.";
        }
    } catch (PDOException $e) {
        $error = "Erro na consulta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        E-mail: <input type="email" name="email" required><br><br>
        Senha: <input type="password" name="senha" required><br><br>
        <button type="submit" name="login">Entrar</button>
    </form>
</body>
</html>
