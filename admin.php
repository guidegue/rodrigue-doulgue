<?php
session_start();
require_once 'includes/db.php';
$db = initDB();

$MOT_DE_PASSE = "DOULGUE2026";
$message = "";

if (isset($_POST['login'])) {
    if ($_POST['password'] === $MOT_DE_PASSE) {
        $_SESSION['admin'] = true;
    } else {
        $message = "Mot de passe incorrect !";
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: /admin.php');
    exit;
}

if (isset($_SESSION['admin'])) {
    if (isset($_POST['ajouter_produit'])) {
        $stmt = $db->prepare("INSERT INTO produits (titre, description, prix, categorie, image, video, promo) VALUES (:t, :d, :p, :c, :i, :v, :pr)");
        $stmt->bindValue(':t', $_POST['titre'], SQLITE3_TEXT);
        $stmt->bindValue(':d', $_POST['description'], SQLITE3_TEXT);
        $stmt->bindValue(':p', $_POST['prix'], SQLITE3_TEXT);
        $stmt->bindValue(':c', $_POST['categorie'], SQLITE3_TEXT);
        $stmt->bindValue(':i', $_POST['image'], SQLITE3_TEXT);
        $stmt->bindValue(':v', $_POST['video'], SQLITE3_TEXT);
        $stmt->bindValue(':pr', $_POST['promo'], SQLITE3_TEXT);
        $stmt->execute();
        $message = "✅ Produit ajouté avec succès !";
    }
    if (isset($_POST['supprimer_produit'])) {
        $stmt = $db->prepare("DELETE FROM produits WHERE id = :id");
        $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
        $stmt->execute();
        $message = "✅ Produit supprimé.";
    }
    if (isset($_POST['ajouter_video'])) {
        $stmt = $db->prepare("INSERT INTO videos (titre, description, url, categorie) VALUES (:t, :d, :u, :c)");
        $stmt->bindValue(':t', $_POST['vid_titre'], SQLITE3_TEXT);
        $stmt->bindValue(':d', $_POST['vid_description'], SQLITE3_TEXT);
        $stmt->bindValue(':u', $_POST['vid_url'], SQLITE3_TEXT);
        $stmt->bindValue(':c', $_POST['vid_categorie'], SQLITE3_TEXT);
        $stmt->execute();
        $message = "✅ Vidéo publiée avec succès !";
    }
    if (isset($_POST['supprimer_video'])) {
        $stmt = $db->prepare("DELETE FROM videos WHERE id = :id");
        $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
        $stmt->execute();
        $message = "✅ Vidéo supprimée.";
    }
    if (isset($_POST['supprimer_commentaire'])) {
        $stmt = $db->prepare("DELETE FROM commentaires WHERE id = :id");
        $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
        $stmt->execute();
        $message = "✅ Commentaire supprimé.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Rodrigue DOULGUE</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .login-box { max-width:400px; margin:100px auto; background:white; padding:40px; border-radius:15px; box-shadow:0 10px 30px rgba(45,10,94,0.2); }
        .tab-buttons { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; }
        .tab-btn { background:#2d0a5e; color:white; padding:10px 20px; border:none; border-radius:8px; cursor:pointer; font-size:14px; text-decoration:none; display:inline-block; }
        .tab-btn.active, .tab-btn:hover { background:#FFD700; color:#2d0a5e; font-weight:bold; }
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:15px; margin-bottom:20px; }
        .stat-box { background:linear-gradient(135deg,#1a0533,#2d0a5e); color:white; padding:20px; border-radius:10px; text-align:center; }
        .stat-box h3 { font-size:36px; color:#FFD700; }
        .form-group { margin-bottom:15px; }
        .form-group label { display:block; color:#2d0a5e; font-weight:bold; margin-bottom:5px; }
        .form-group input, .form-group textarea, .form-group select { width:100%; padding:10px 15px; border:2px solid #eee; border-radius:8px; font-size:14px; }
        .produit-admin-card { background:white; border-radius:10px; padding:15px; margin-bottom:15px; border-left:4px solid #2d0a5e; box-shadow:0 2px 8px rgba(0,0,0,0.08); }
        .produit-admin-card img { width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:10px; }
        .btn-danger { background:red; color:white; padding:6px 15px; border:none; border-radius:5px; cursor:pointer; }
        .produits-admin-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
        .msg { color:green; font-weight:bold; text-align:center; padding:10px; background:#e8f5e9; border-radius:8px; margin-bottom:15px; }
        .preview-img { max-width:200px; border-radius:8px; margin-top:10px; }
    </style>
</head>
<body style="background:linear-gradient(135deg,#1a0533,#2d0a5e); min-height:100vh;">

<?php if (!isset($_SESSION['admin'])): ?>
<div class="login-box">
    <h2 style="text-align:center; color:#2d0a5e; margin-bottom:20px;">🔐 Espace Admin</h2>
    <p style="text-align:center; color:#666; margin-bottom:20px;">Rodrigue DOULGUE</p>
    <?php if ($message): ?><p style="color:red; text-align:center;"><?= $message ?></p><?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <input type="password" name="password" placeholder="Mot de passe admin" required>
        </div>
        <button type="submit" name="login" class="btn" style="width:100%;">Se connecter</button>
    </form>
</div>

<?php else: ?>
<header>
    <nav>
        <div class="logo">🔐 Admin - Rodrigue DOULGUE</div>
        <ul>
            <li><a href="/index.php">Voir le site</a></li>
            <li><a href="/boutique.php">Boutique</a></li>
            <li><a href="/videos.php">Vidéos</a></li>
            <form method="POST" style="display:inline;">
                <li><button type="submit" name="logout" style="background:none; border:none; color:#ff4444; cursor:pointer; font-size:15px;">Déconnexion</button></li>
            </form>
        </ul>
    </nav>
</header>
<main>
    <h1 style="margin-bottom:20px;">Tableau de bord</h1>
    <?php if ($message): ?><div class="msg"><?= $message ?></div><?php endif; ?>

    <?php
    $nb_produits = $db->querySingle("SELECT COUNT(*) FROM produits");
    $nb_videos = $db->querySingle("SELECT COUNT(*) FROM videos");
    $nb_commentaires = $db->querySingle("SELECT COUNT(*) FROM commentaires");
    $nb_visiteurs = $db->querySingle("SELECT COUNT(*) FROM visiteurs");
    ?>
    <div class="stats-grid">
        <div class="stat-box"><h3><?= $nb_produits ?></h3><p>Produits</p></div>
        <div class="stat-box"><h3><?= $nb_videos ?></h3><p>Vidéos</p></div>
        <div class="stat-box"><h3><?= $nb_commentaires ?></h3><p>Commentaires</p></div>
        <div class="stat-box"><h3><?= $nb_visiteurs ?></h3><p>Visiteurs</p></div>
    </div>

    <?php $tab = isset($_GET['tab']) ? $_GET['tab'] : 'ajouter'; ?>
    <div class="tab-buttons">
        <a href="?tab=ajouter" class="tab-btn <?= $tab=='ajouter'?'active':'' ?>">➕ Ajouter Produit</a>
        <a href="?tab=produits" class="tab-btn <?= $tab=='produits'?'active':'' ?>">🛍️ Mes Produits</a>
        <a href="?tab=video" class="tab-btn <?= $tab=='video'?'active':'' ?>">🎥 Publier Vidéo</a>
        <a href="?tab=mes-videos" class="tab-btn <?= $tab=='mes-videos'?'active':'' ?>">📹 Mes Vidéos</a>
        <a href="?tab=commentaires" class="tab-btn <?= $tab=='commentaires'?'active':'' ?>">💬 Commentaires</a>
        <a href="?tab=visiteurs" class="tab-btn <?= $tab=='visiteurs'?'active':'' ?>">👥 Visiteurs</a>
    </div>

    <?php if ($tab == 'ajouter'): ?>
    <div class="section">
        <h2>➕ Ajouter un Produit</h2>
        <form method="POST">
            <div class="form-group">
                <label>Titre du produit *</label>
                <input type="text" name="titre" placeholder="Ex: Guide du Marketing Relationnel" required>
            </div>
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" rows="3" placeholder="Décrivez votre produit..." required></textarea>
            </div>
            <div class="form-group">
                <label>Prix *</label>
                <input type="text" name="prix" placeholder="Ex: 25 000 FCFA" required>
            </div>
            <div class="form-group">
                <label>Catégorie</label>
                <select name="categorie">
                    <option value="livres">📚 Livre</option>
                    <option value="formations">🎓 Formation</option>
                    <option value="outils">🛠️ Outil</option>
                    <option value="coaching">⭐ Coaching</option>
                    <option value="autre">📦 Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label>URL de l'image</label>
                <input type="text" name="image" placeholder="https://..." id="img-url" oninput="previewImg()">
                <img id="preview" src="" style="display:none;" class="preview-img">
            </div>
            <div class="form-group">
                <label>URL Vidéo YouTube (optionnel)</label>
                <input type="text" name="video" placeholder="https://youtube.com/watch?v=...">
            </div>
            <div class="form-group">
                <label>Promotion (optionnel)</label>
                <input type="text" name="promo" placeholder="Ex: -20% cette semaine !">
            </div>
            <button type="submit" name="ajouter_produit" class="btn" style="width:100%;">✅ Publier le produit</button>
        </form>
    </div>

    <?php elseif ($tab == 'produits'): ?>
    <div class="section">
        <h2>🛍️ Mes Produits</h2>
        <div class="produits-admin-grid">
        <?php
        $produits = $db->query("SELECT * FROM produits ORDER BY date_ajout DESC");
        $found = false;
        while ($p = $produits->fetchArray(SQLITE3_ASSOC)) {
            $found = true;
            $img = $p['image'] ? "<img src='{$p['image']}' alt='{$p['titre']}'>" : "<div style='width:100%;height:150px;background:#f0e6ff;display:flex;align-items:center;justify-content:center;font-size:50px;border-radius:8px;'>📦</div>";
            echo "<div class='produit-admin-card'>{$img}<span class='badge'>{$p['categorie']}</span><h3 style='color:#2d0a5e;margin:8px 0;'>{$p['titre']}</h3><p style='color:#666;font-size:13px;'>{$p['description']}</p><p style='font-size:18px;font-weight:bold;color:#2d0a5e;'>{$p['prix']}</p><p style='font-size:12px;color:#999;'>Publié le {$p['date_ajout']}</p><form method='POST'><input type='hidden' name='id' value='{$p['id']}'><button type='submit' name='supprimer_produit' class='btn-danger'>🗑️ Supprimer</button></form></div>";
        }
        if (!$found) echo "<p>Aucun produit ajouté.</p>";
        ?>
        </div>
    </div>

    <?php elseif ($tab == 'video'): ?>
    <div class="section">
        <h2>🎥 Publier une Vidéo</h2>
        <form method="POST">
            <div class="form-group">
                <label>Titre de la vidéo *</label>
                <input type="text" name="vid_titre" placeholder="Ex: Comment réussir en marketing" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="vid_description" rows="3" placeholder="Décrivez votre vidéo..."></textarea>
            </div>
            <div class="form-group">
                <label>URL YouTube *</label>
                <input type="text" name="vid_url" placeholder="https://youtube.com/watch?v=..." required>
            </div>
            <div class="form-group">
                <label>Catégorie</label>
                <select name="vid_categorie">
                    <option value="formation">🎓 Formation</option>
                    <option value="temoignage">⭐ Témoignage</option>
                    <option value="motivation">💪 Motivation</option>
                    <option value="autre">📦 Autre</option>
                </select>
            </div>
            <button type="submit" name="ajouter_video" class="btn" style="width:100%;">🎥 Publier la vidéo</button>
        </form>
    </div>

    <?php elseif ($tab == 'mes-videos'): ?>
    <div class="section">
        <h2>📹 Mes Vidéos</h2>
        <div class="produits-admin-grid">
        <?php
        $videos = $db->query("SELECT * FROM videos ORDER BY date_ajout DESC");
        $found = false;
        while ($v = $videos->fetchArray(SQLITE3_ASSOC)) {
            $found = true;
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $v['url'], $m);
            $vid_id = $m[1] ?? '';
            $embed = $vid_id ? "<iframe width='100%' height='180' src='https://www.youtube.com/embed/{$vid_id}' frameborder='0' allowfullscreen style='border-radius:8px;margin-bottom:10px;'></iframe>" : '';
            echo "<div class='produit-admin-card'>{$embed}<span class='badge'>{$v['categorie']}</span><h3 style='color:#2d0a5e;margin:8px 0;'>{$v['titre']}</h3><p style='color:#666;font-size:13px;'>{$v['description']}</p><p style='font-size:12px;color:#999;'>Publié le {$v['date_ajout']}</p><form method='POST'><input type='hidden' name='id' value='{$v['id']}'><button type='submit' name='supprimer_video' class='btn-danger'>🗑️ Supprimer</button></form></div>";
        }
        if (!$found) echo "<p>Aucune vidéo publiée.</p>";
        ?>
        </div>
    </div>

    <?php elseif ($tab == 'commentaires'): ?>
    <div class="section">
        <h2>💬 Commentaires des clients</h2>
        <?php
        $commentaires = $db->query("SELECT * FROM commentaires ORDER BY date_ajout DESC");
        $found = false;
        while ($c = $commentaires->fetchArray(SQLITE3_ASSOC)) {
            $found = true;
            echo "<div class='produit-admin-card'><p><strong>{$c['nom']}</strong> — ⭐ {$c['note']}/5</p><p>{$c['message']}</p><p style='font-size:12px;color:#999;'>{$c['date_ajout']}</p><form method='POST'><input type='hidden' name='id' value='{$c['id']}'><button type='submit' name='supprimer_commentaire' class='btn-danger'>🗑️ Supprimer</button></form></div>";
        }
        if (!$found) echo "<p>Aucun commentaire pour le moment.</p>";
        ?>
    </div>

    <?php elseif ($tab == 'visiteurs'): ?>
    <div class="section">
        <h2>👥 Historique des Visiteurs</h2>
        <?php
        $visiteurs = $db->query("SELECT * FROM visiteurs ORDER BY heure DESC LIMIT 100");
        $found = false;
        $i = 1;
        while ($v = $visiteurs->fetchArray(SQLITE3_ASSOC)) {
            $found = true;
            echo "<div class='produit-admin-card'><p><strong>#{$i}</strong> | ⏰ {$v['heure']}</p><p>🌍 {$v['pays']} — 🏙️ {$v['ville']}</p><p>📄 Page: {$v['page']}</p></div>";
            $i++;
        }
        if (!$found) echo "<p>Aucun visiteur pour le moment.</p>";
        ?>
    </div>
    <?php endif; ?>
</main>
<?php endif; ?>

<script>
function previewImg() {
    const url = document.getElementById("img-url").value;
    const img = document.getElementById("preview");
    if (url) { img.src = url; img.style.display = "block"; }
    else { img.style.display = "none"; }
}
</script>
</body>
</html>
