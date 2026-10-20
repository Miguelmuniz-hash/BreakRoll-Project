<?php
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/config.php';
include_once __DIR__ . '/includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT c.*, cat.nome_categorias FROM conteudo c LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria WHERE c.id_conteudo = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "<div class='container'><p>Conteúdo não encontrado.</p></div>";
    include_once __DIR__ . '/includes/footer.php';
    exit;
}

// Ação de Favoritar
$mensagem_fav = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fav_action'])) {
    if (isset($_SESSION['id_user']) || isset($_SESSION['usuario_id'])) {
        $id_user = $_SESSION['id_user'] ?? $_SESSION['usuario_id'];
        // Verifica se já favoritou
        $check = $pdo->prepare("SELECT * FROM favoritos WHERE id_user = ? AND id_conteudo = ?");
        $check->execute([$id_user, $id]);
        if ($check->rowCount() == 0) {
            $fav = $pdo->prepare("INSERT INTO favoritos (id_user, id_conteudo) VALUES (?, ?)");
            $fav->execute([$id_user, $id]);
            $mensagem_fav = "Adicionado aos Favoritos com sucesso!";
        } else {
            $mensagem_fav = "Este item já está nos seus favoritos!";
        }
    } else {
        header('Location: ' . site_url('login.php'));
        exit;
    }
}
?>

<div class="container">
    <?php if (!empty($mensagem_fav)): ?>
        <div class="alert-error" style="border-color: #00ff66; color: #00ff66; background: rgba(0,255,102,0.1);"><?= $mensagem_fav ?></div>
    <?php endif; ?>

    <div class="detail-wrapper">
        <img src="<?= htmlspecialchars($item['imagem_conteudo']) ?>" alt="Capa" class="detail-img">
        <div class="detail-info">
            <span class="content-category"><?= htmlspecialchars($item['nome_categorias']) ?></span>
            <h1 class="detail-title"><?= htmlspecialchars($item['titulo_conteudo']) ?></h1>
            <p class="detail-desc"><?= nl2br(htmlspecialchars($item['descricao_conteudo'])) ?></p>

            <div class="detail-actions">
                <?php if (!empty($item['url_conteudo'])): ?>
                    <a href="<?= htmlspecialchars($item['url_conteudo']) ?>" target="_blank" class="btn-submit" style="display:inline-block; text-align:center; text-decoration:none; width:auto; padding: 10px 20px;">Assistir Trailer / Ler</a>
                <?php endif; ?>

                <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="fav_action" value="1">
                    <button type="submit" class="btn-details" style="padding: 10px 20px; cursor:pointer;">Adicionar aos Favoritos</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>