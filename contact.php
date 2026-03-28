<?php
require_once 'includes/db.php';
$db = initDB();
$message_succes = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Location: https://wa.me/237689085020?text=' . urlencode("Nom: " . $_POST['nom'] . "\nEmail: " . $_POST['email'] . "\nMessage: " . $_POST['message']));
    exit;
}
include 'includes/header.php';
?>
<section class="hero">
    <h1>📧 Contactez-moi</h1>
    <p>Je suis disponible pour répondre à toutes vos questions</p>
</section>
<main>
    <div class="contact-grid">
        <div class="contact-info">
            <h2>Mes Coordonnées</h2>
            <div class="contact-item">
                <span>📱</span>
                <div><p>WhatsApp</p><a href="https://wa.me/237689085020" target="_blank">+237 689 085 020</a></div>
            </div>
            <div class="contact-item">
                <span>📧</span>
                <div><p>Email</p><a href="mailto:roidedieu89@gmail.com">roidedieu89@gmail.com</a></div>
            </div>
            <br>
            <a href="https://wa.me/237689085020" class="btn btn-whatsapp" target="_blank">📱 Écrire sur WhatsApp</a>
        </div>
        <div>
            <h2 style="color:#2d0a5e; margin-bottom:20px;">Envoyer un message</h2>
            <form method="POST">
                <input type="text" name="nom" placeholder="Votre nom complet" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <input type="tel" name="telephone" placeholder="Votre numéro WhatsApp">
                <select name="sujet">
                    <option value="">Choisir un sujet</option>
                    <option value="formation">Je veux une formation</option>
                    <option value="produit">Commander un produit</option>
                    <option value="coaching">Coaching personnalisé</option>
                    <option value="autre">Autre</option>
                </select>
                <textarea name="message" placeholder="Votre message" required></textarea>
                <button type="submit" class="btn" style="width:100%;">Envoyer le message</button>
            </form>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
