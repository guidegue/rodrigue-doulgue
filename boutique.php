<?php
require_once 'includes/db.php';
$db = initDB();
$cat = isset($_GET['cat']) ? $_GET['cat'] : 'tous';
if ($cat === 'tous') {
    $produits = $db->query("SELECT * FROM produits ORDER BY date_ajout DESC");
} else {
    $stmt = $db->prepare("SELECT * FROM produits WHERE categorie = :cat ORDER BY date_ajout DESC");
    $stmt->bindValue(':cat', $cat, SQLITE3_TEXT);
    $produits = $stmt->execute();
}
include 'includes/header.php';
?>
<section class="hero">
    <h1>🛍️ Boutique</h1>
    <p>Découvrez tous les produits de Rodrigue DOULGUE</p>
</section>
<main>
    <div class="section">
        <div class="filtre-buttons">
            <a href="/boutique.php" class="filtre-btn <?= $cat=='tous'?'active':'' ?>">Tous</a>
            <a href="/boutique.php?cat=livres" class="filtre-btn <?= $cat=='livres'?'active':'' ?>">📚 Livres</a>
            <a href="/boutique.php?cat=formations" class="filtre-btn <?= $cat=='formations'?'active':'' ?>">🎓 Formations</a>
            <a href="/boutique.php?cat=outils" class="filtre-btn <?= $cat=='outils'?'active':'' ?>">🛠️ Outils</a>
            <a href="/boutique.php?cat=coaching" class="filtre-btn <?= $cat=='coaching'?'active':'' ?>">⭐ Coaching</a>
        </div>
        <div class="produits-grid">
        <?php
        $found = false;
        while ($p = $produits->fetchArray(SQLITE3_ASSOC)) {
            $found = true;
            $img = $p['image'] ? "<img src='{$p['image']}' alt='{$p['titre']}'>" : "<div style='width:100%;height:200px;background:#f0e6ff;display:flex;align-items:center;justify-content:center;font-size:60px;'>📦</div>";
            $promo = $p['promo'] ? "<span style='background:red;color:white;padding:3px 8px;border-radius:10px;font-size:12px;'>{$p['promo']}</span>" : '';
            $video = '';
            if ($p['video']) {
                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $p['video'], $m);
                $vid_id = $m[1] ?? '';
                if ($vid_id) $video = "<iframe width='100%' height='200' src='https://www.youtube.com/embed/{$vid_id}' frameborder='0' allowfullscreen></iframe>";
            }
            echo "<div class='carte-produit'>{$img}{$video}<div class='produit-info'><span class='badge'>{$p['categorie']}</span> {$promo}<h3>{$p['titre']}</h3><p>{$p['description']}</p><span class='prix'>{$p['prix']}</span><a href='https://wa.me/237689085020?text=Je veux commander: {$p['titre']}' class='btn btn-whatsapp' target='_blank'>Commander via WhatsApp</a></div></div>";
        }
        if (!$found) echo "<p>Aucun produit dans cette catégorie pour le moment.</p>";
        ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
