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
    <title>Break DB - Streaming de Animes & Mangás</title>
    <link rel="stylesheet" href="<?= asset_url('css/style.css') ?>">
    <link rel="shortcut icon" href="<?= asset_url('favicon.ico') ?>" type="image/x-icon">
</head>
<body>

    <header>
        <div class="logo-area">
            <a href="<?= site_url('index.php') ?>" style="text-decoration: none;">
                <h1>BREAK <span>DB</span></h1>
            </a>
        </div>

        <nav>
            <ul>
                <li><a href="<?= site_url('index.php') ?>">Início</a></li>
                <?php if (isset($_SESSION['id_user']) || isset($_SESSION['usuario_id'])): ?>
                    <li><a href="<?= site_url('favoritos.php') ?>">Meus Favoritos</a></li>
                    <li style="color: var(--text-gray);">Olá, <?= htmlspecialchars($_SESSION['nome_user'] ?? $_SESSION['usuario_nome'] ?? 'Usuário') ?></li>
                    <li><a href="<?= site_url('logout.php') ?>" style="color: var(--primary-red);">Sair</a></li>
                <?php else: ?>
                    <li><a href="<?= site_url('login.php') ?>">Entrar</a></li>
                    <li><a href="<?= site_url('cadastro.php') ?>" class="btn-nav-login">Cadastrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>