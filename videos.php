<?php
require_once 'includes/db.php';
$db = initDB();
$videos = $db->query("SELECT * FROM videos ORDER BY date_ajout DESC");
include 'includes/header.php';
?>
<section class="hero">
    <h1>🎥 Vidéos</h1>
    <p>Formations et contenus exclusifs de Rodrigue DOULGUE</p>
</section>
<main>
    <div class="section">
        <div class="produits-grid">
        <?php
        $found = false;
        while ($v = $videos->fetchArray(SQLITE3_ASSOC)) {
            $found = true;
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $v['url'], $m);
            $vid_id = $m[1] ?? '';
            $embed = $vid_id ? "<iframe width='100%' height='200' src='https://www.youtube.com/embed/{$vid_id}' frameborder='0' allowfullscreen style='border-radius:8px;'></iframe>" : '';
            echo "<div class='carte-produit'>{$embed}<div class='produit-info'><span class='badge'>{$v['categorie']}</span><h3>{$v['titre']}</h3><p>{$v['description']}</p><small>📅 {$v['date_ajout']}</small></div></div>";
        }
        if (!$found) echo "<p>Aucune vidéo publiée pour le moment.</p>";
        ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
