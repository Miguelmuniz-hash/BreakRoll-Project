<?php
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/conexao.php';

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senhaPura = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senhaPura)) {
        $mensagemErro = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        $senhaHash = password_hash($senhaPura, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO usuarios (nome_user, email_user, senha_user) VALUES (:nome, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash
            ]);

            $usuarioId = $pdo->lastInsertId();

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['id_user'] = $usuarioId;
            $_SESSION['nome_user'] = $nome;
            $_SESSION['usuario_id'] = $usuarioId;
            $_SESSION['usuario_nome'] = $nome;

            $dadosEmail = [
                'from'    => 'onboarding@resend.dev',
                'to'      => [DONO_EMAIL],
                'subject' => 'Novo cadastro no BreakRoll!',
                'html'    => "<h2>Novo usuário cadastrado!</h2>
                              <p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>
                              <p><strong>E-mail:</strong> " . htmlspecialchars($email) . "</p>
                              <p>Data/Hora: " . date('d/m/Y H:i:s') . "</p>"
            ];

            $ch = curl_init('https://api.resend.com/emails');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosEmail));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . RESEND_API_KEY,
                'Content-Type: application/json'
            ]);

            curl_exec($ch);
            curl_close($ch);

            header('Location: index.php');
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                $mensagemErro = "Este e-mail já está cadastrado. Tente fazer login ou use outro e-mail.";
            } else {
                $mensagemErro = "Ocorreu um erro ao realizar o cadastro. Tente novamente mais tarde.";
            }
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <div class="auth-card">
        <h2>Crie sua Conta</h2>
        
        <?php if (!empty($mensagemErro)): ?>
            <p class="error-msg"><?= htmlspecialchars($mensagemErro) ?></p>
        <?php endif; ?>

        <form action="cadastro.php" method="POST">
            <label>Nome completo:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" placeholder="Digite seu nome" required>

            <label>E-mail:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="seu@email.com" required>

            <label>Senha:</label>
            <input type="password" name="senha" placeholder="Crie uma senha forte" required>

            <button type="submit" class="btn-submit">Cadastrar e Entrar</button>
        </form>

        <p class="auth-links">Já possui uma conta? <a href="login.php">Faça Login</a></p>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>