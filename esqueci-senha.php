<?php
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/config.php';
include_once __DIR__ . '/includes/header.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email_user']);
    
    if (!empty($email)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email_user = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $mensagem = "✅ Um e-mail de redefinição de senha foi simulado e enviado com sucesso para $email!";
        } else {
            $mensagem = "❌ Este e-mail não foi encontrado no nosso banco de dados.";
        }
    }
}
?>

<div class="container">
    <div class="form-box">
        <h2 class="section-title">Redefinir Senha</h2>
        
        <?php if (!empty($mensagem)): ?>
            <div class="alert-error" style="color: #fff; border-color: var(--primary-red);"><?= $mensagem ?></div>
        <?php endif; ?>

        <form action="<?= site_url('esqueci-senha.php') ?>" method="POST">
            <div class="form-group">
                <label for="email">Digite seu E-mail cadastrado:</label>
                <input type="email" id="email" name="email_user" required placeholder="seu@email.com">
            </div>
            <button type="submit" class="btn-submit">Enviar Link de Recuperação</button>
        </form>
        <p class="form-footer-text"><a href="<?= site_url('login.php') ?>">Voltar para o Login</a></p>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>