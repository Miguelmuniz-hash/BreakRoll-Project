<?php
require_once 'conexao.php';
include_once 'includes/header.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$stmt = $pdo->prepare("
    SELECT c.*, cat.nome_categorias 
    FROM favoritos f 
    JOIN conteudo c ON f.id_conteudo = c.id_conteudo 
    LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria 
    WHERE f.id_user = ?
");
$stmt->execute([$id_user]);
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="section-title">Meus Favoritos</h2>

    <div class="content-grid">
        <?php if (count($favoritos) > 0): ?>
            <?php foreach ($favoritos as $item): ?>
                <div class="content-card">
                    <img src="<?= htmlspecialchars($item['imagem_conteudo']) ?>" class="content-img">
                    <div class="content-body">
                        <span class="content-category"><?= htmlspecialchars($item['nome_categorias']) ?></span>
                        <h3 class="content-title"><?= htmlspecialchars($item['titulo_conteudo']) ?></h3>
                        <a href="detalhe.php?id=<?= $item['id_conteudo'] ?>" class="btn-details">Ver Detalhes</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--text-gray);">Você ainda não possui nenhum item salvo nos favoritos.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>