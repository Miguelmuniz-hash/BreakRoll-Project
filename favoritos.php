<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexao.php';

// Redireciona para o login se o usuário não estiver logado
$usuario_id = $_SESSION['usuario_id'] ?? $_SESSION['id_user'] ?? null;
if (!$usuario_id) {
    header('Location: login.php');
    exit;
}

// Processa a remoção do favorito
if (isset($_GET['remover_id'])) {
    $id_conteudo_remover = (int)$_GET['remover_id'];
    
    try {
        $stmt_del = $pdo->prepare("DELETE FROM favoritos WHERE id_user = :id_user AND id_conteudo = :id_conteudo");
        $stmt_del->execute([
            ':id_user' => $usuario_id,
            ':id_conteudo' => $id_conteudo_remover
        ]);
        
        header('Location: favoritos.php?status=removido');
        exit;
    } catch (PDOException $e) {
        $erro = "Erro ao remover dos favoritos.";
    }
}

// Busca os itens favoritados pelo usuário logado
$sql = "SELECT c.*, cat.nome_categorias 
        FROM favoritos f 
        INNER JOIN conteudo c ON f.id_conteudo = c.id_conteudo 
        LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria 
        WHERE f.id_user = :id_user";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_user' => $usuario_id]);
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include_once 'includes/header.php';
?>

<div class="container">
    <h2 class="section-title">Meus Favoritos</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'removido'): ?>
        <p class="success-msg" style="max-width: 400px; margin-bottom: 20px;">Anime removido dos favoritos com sucesso!</p>
    <?php endif; ?>

    <div class="content-grid">
        <?php if (count($favoritos) > 0): ?>
            <?php foreach ($favoritos as $item): ?>
                <div class="content-card">
                    <img src="<?= htmlspecialchars($item['imagem_conteudo'] ?: 'https://via.placeholder.com/300x200?text=Sem+Imagem') ?>" alt="Capa" class="content-img">
                    <div class="content-body">
                        <span class="content-category"><?= htmlspecialchars($item['nome_categorias'] ?? 'Geral') ?></span>
                        <h3 class="content-title"><?= htmlspecialchars($item['titulo_conteudo']) ?></h3>
                        
                        <div class="actions-group" style="display: flex; flex-direction: column; gap: 8px; margin-top: 10px;">
                            <a href="detalhe.php?id=<?= $item['id_conteudo'] ?>" class="btn-details">Ver Detalhes</a>
                            <a href="favoritos.php?remover_id=<?= $item['id_conteudo'] ?>" class="btn-remove" onclick="return confirm('Tem certeza que deseja remover este anime dos favoritos?');">
                                Remover dos Favoritos
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--text-gray);">Você ainda não possui animes salvos em seus favoritos.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>