<?php
require_once 'includes/db.php';
$db = initDB();
include 'includes/header.php';
?>
<section class="hero">
    <h1>Rodrigue DOULGUE</h1>
    <p>Expert en Marketing Relationnel | Formateur | Entrepreneur</p>
    <p>Transformez votre vie grâce au marketing relationnel !</p>
    <div class="hero-buttons">
        <a href="/formations.php" class="btn">📚 Voir mes formations</a>
        <a href="/boutique.php" class="btn btn-purple">🛍️ Boutique</a>
        <a href="https://wa.me/237689085020" class="btn btn-whatsapp" target="_blank">📱 WhatsApp</a>
    </div>
</section>
<main>
    <div class="section">
        <h2>🌟 Pourquoi choisir Rodrigue ?</h2>
        <div class="produits-grid">
            <div style="text-align:center; padding:20px; background:#f8f4ff; border-radius:10px;">
                <div style="font-size:40px;">🎯</div>
                <h3 style="color:#2d0a5e; margin:10px 0;">Expert Certifié</h3>
                <p>Plus de 5 ans d'expérience en marketing relationnel</p>
            </div>
            <div style="text-align:center; padding:20px; background:#f8f4ff; border-radius:10px;">
                <div style="font-size:40px;">👥</div>
                <h3 style="color:#2d0a5e; margin:10px 0;">+500 Étudiants</h3>
                <p>Formés avec succès dans toute l'Afrique</p>
            </div>
            <div style="text-align:center; padding:20px; background:#f8f4ff; border-radius:10px;">
                <div style="font-size:40px;">💰</div>
                <h3 style="color:#2d0a5e; margin:10px 0;">Résultats Prouvés</h3>
                <p>Méthodes testées et approuvées</p>
            </div>
            <div style="text-align:center; padding:20px; background:#f8f4ff; border-radius:10px;">
                <div style="font-size:40px;">📱</div>
                <h3 style="color:#2d0a5e; margin:10px 0;">Support 24/7</h3>
                <p>Accompagnement personnalisé via WhatsApp</p>
            </div>
        </div>
    </div>
    <?php
    $produits = $db->query("SELECT * FROM produits ORDER BY date_ajout DESC LIMIT 6");
    $has_produits = false;
    $produits_html = '';
    while ($p = $produits->fetchArray(SQLITE3_ASSOC)) {
        $has_produits = true;
        $img = $p['image'] ? "<img src='{$p['image']}' alt='{$p['titre']}' style='width:100%;height:200px;object-fit:cover;'>" : "<div style='width:100%;height:200px;background:#f0e6ff;display:flex;align-items:center;justify-content:center;font-size:50px;'>📦</div>";
        $promo = $p['promo'] ? "<span style='background:red;color:white;padding:3px 8px;border-radius:10px;font-size:12px;'>{$p['promo']}</span>" : '';
        $produits_html .= "<div class='carte-produit'>{$img}<div class='produit-info'><span class='badge'>{$p['categorie']}</span> {$promo}<h3>{$p['titre']}</h3><p>{$p['description']}</p><span class='prix'>{$p['prix']}</span><a href='https://wa.me/237689085020?text=Je veux commander: {$p['titre']}' class='btn btn-whatsapp' target='_blank'>Commander</a></div></div>";
    }
    if ($has_produits) {
        echo "<div class='section'><h2>🛍️ Produits récents</h2><div class='produits-grid'>{$produits_html}</div><div style='text-align:center;margin-top:20px;'><a href='/boutique.php' class='btn'>Voir tous les produits</a></div></div>";
    }
    ?>
    <div class="section">
        <h2>⭐ Témoignages</h2>
        <div class="temoignage-card">
            <p>"Grâce à Rodrigue, j'ai pu construire un réseau solide et générer mes premiers revenus en seulement 2 mois !"</p>
            <strong>— Marie T., Yaoundé</strong>
        </div>
        <div class="temoignage-card">
            <p>"Les formations sont claires, pratiques et vraiment efficaces. Je recommande à 100% !"</p>
            <strong>— Paul K., Douala</strong>
        </div>
    </div>
    <div class="section" style="text-align:center; background:linear-gradient(135deg,#1a0533,#2d0a5e); color:white;">
        <h2 style="color:#FFD700; border:none; padding:0;">📱 Contactez-moi maintenant !</h2>
        <p style="margin:15px 0;">Prêt à transformer votre vie ? Écrivez-moi sur WhatsApp !</p>
        <a href="https://wa.me/237689085020" class="btn" target="_blank">📱 +237 689 085 020</a>
        <a href="mailto:roidedieu89@gmail.com" class="btn btn-purple" style="margin-left:10px;">📧 Email</a>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
