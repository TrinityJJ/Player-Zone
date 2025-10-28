<?php
// AVISO: uso apenas local/temporário.
// Depois de rodar, APAGUE este arquivo por segurança.

$email = 'guilhermefontedasilva95@gmail.com';
$newPlainPassword = '12345';

require 'db_connect.php';

try {
    // Verifica se o usuário existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Usuário com email {$email} não encontrado.<br>";
        exit;
    }

    // Gera hash seguro da nova senha
    $newHash = password_hash($newPlainPassword, PASSWORD_DEFAULT);

    // Atualiza a senha no banco e garante que seja admin
    $update = $conn->prepare("UPDATE usuarios SET senha = ?, admin = 1 WHERE email = ?");
    $update->execute([$newHash, $email]);

    echo "Senha atualizada com sucesso para {$email}.<br>";
    echo "Senha usada para teste: <strong>12345</strong><br>";
    echo "APAGUE este arquivo após uso e troque a senha para algo seguro depois.";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
