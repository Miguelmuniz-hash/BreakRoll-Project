<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <title>Break DB - Streaming de Animes & Mangás</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

</head>
<body>

    <header>
        <div class="logo-area">
            <a href="index.php">
                <img src="https://www.image2url.com/r2/default/images/1792518054011-19f958fb-8d64-4924-9803-b3d23112a04b.png" alt="Break DB Logo" class="site-logo">
            </a>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <?php if (isset($_SESSION['usuario_id']) || isset($_SESSION['id_user'])): ?>
                    <li><a href="favoritos.php">Meus Favoritos</a></li>
                    <li style="color: var(--text-gray);">Olá, <?= htmlspecialchars($_SESSION['usuario_nome'] ?? $_SESSION['nome_user'] ?? 'Usuário') ?></li>
                    <li><a href="logout.php" style="color: var(--primary-red);">Sair</a></li>
                <?php else: ?>
                    <li><a href="login.php">Entrar</a></li>
                    <li><a href="cadastro.php" class="btn-nav-login">Cadastrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>