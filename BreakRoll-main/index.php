<?php
require_once 'conexao.php';
include_once 'includes/header.php';

$categoria_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

$stmt_cat = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

if ($categoria_id > 0) {
    $sql_conteudo = "SELECT c.*, cat.nome_categorias 
                    FROM conteudo c 
                    LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria 
                    WHERE c.id_categoria = ?";
    $stmt_cont = $pdo->prepare($sql_conteudo);
    $stmt_cont->execute([$categoria_id]);
} else {
    $sql_conteudo = "SELECT c.*, cat.nome_categorias 
                    FROM conteudo c 
                    LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria";
    $stmt_cont = $pdo->query($sql_conteudo);
}
$conteudos = $stmt_cont->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    
    <!-- Barra de Busca Instantânea JS -->
    <div class="search-box-area">
        <input type="text" id="search-input" placeholder="Pesquisar por título, gênero ou mangá..." class="search-bar">
    </div>

    <!-- Navegação por Categorias -->
    <h2 class="section-title">Categorias</h2>
    <div class="categories-nav">
        <a href="index.php" class="cat-badge <?= $categoria_id == 0 ? 'active' : '' ?>">Todas</a>
        <?php foreach ($categorias as $cat): ?>
            <a href="index.php?cat=<?= $cat['id_categoria'] ?>" class="cat-badge <?= $categoria_id == $cat['id_categoria'] ? 'active' : '' ?>">
                <?= htmlspecialchars($cat['nome_categorias']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Listagem de Conteúdos -->
    <h2 class="section-title">Catálogo de Animes & Mangás</h2>
    <div class="content-grid" id="content-grid">
        <?php if (count($conteudos) > 0): ?>
            <?php foreach ($conteudos as $item): ?>
                <div class="content-card">
                    <img src="<?= htmlspecialchars($item['imagem_conteudo'] ?: 'https://via.placeholder.com/300x200?text=Sem+Imagem') ?>" alt="Capa" class="content-img">
                    <div class="content-body">
                        <span class="content-category"><?= htmlspecialchars($item['nome_categorias'] ?? 'Geral') ?></span>
                        <h3 class="content-title"><?= htmlspecialchars($item['titulo_conteudo']) ?></h3>
                        <p class="content-desc"><?= htmlspecialchars(substr($item['descricao_conteudo'], 0, 80)) ?>...</p>
                        <a href="detalhe.php?id=<?= $item['id_conteudo'] ?>" class="btn-details">Ver Detalhes</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--text-gray);">Nenhum conteúdo cadastrado.</p>
        <?php endif; ?>
    </div>

</div>

<script src="js/busca.js"></script>
<?php include_once 'includes/footer.php'; ?>