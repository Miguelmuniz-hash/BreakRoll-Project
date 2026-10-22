<?php
session_start();
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/config.php';

$erro = '';
$sucesso = '';

if (isset($_GET['status']) && $_GET['status'] === 'sucesso') {
    $sucesso = "Cadastro realizado com sucesso! Faça seu login abaixo.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos!";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email_user = :email");
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha_user'])) {
                $_SESSION['id_user'] = $usuario['id_user'];
                $_SESSION['nome_user'] = $usuario['nome_user'];

                header("Location: index.php");
                exit;
            } else {
                $erro = "E-mail ou senha inválidos.";
            }
        } catch (PDOException $e) {
            $erro = "Erro interno no sistema. Tente novamente mais tarde.";
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <div class="auth-card">
        <h2>Entrar na Plataforma</h2>

        <?php if (!empty($erro)): ?>
            <p class="error-msg"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <p class="success-msg"><?= htmlspecialchars($sucesso) ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label>E-mail:</label>
            <input type="email" name="email" placeholder="seu@email.com" required>
            
            <label>Senha:</label>
            <input type="password" name="senha" placeholder="Sua senha" required>
            
            <button type="submit" class="btn-submit">Entrar</button>
        </form>
        
        <p class="auth-links">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
        <p class="auth-links"><a href="esqueci-senha.php">Esqueceu a senha?</a></p>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
