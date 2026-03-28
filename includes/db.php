<?php
function getDB() {
    $db = new SQLite3(__DIR__ . '/../database.db');
    return $db;
}

function initDB() {
    $db = getDB();
    $db->exec('CREATE TABLE IF NOT EXISTS produits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titre TEXT NOT NULL,
        description TEXT NOT NULL,
        prix TEXT NOT NULL,
        categorie TEXT NOT NULL,
        image TEXT,
        video TEXT,
        promo TEXT,
        date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    $db->exec('CREATE TABLE IF NOT EXISTS videos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titre TEXT NOT NULL,
        description TEXT,
        url TEXT NOT NULL,
        categorie TEXT,
        date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    $db->exec('CREATE TABLE IF NOT EXISTS commentaires (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL,
        produit_id INTEGER,
        note INTEGER,
        message TEXT NOT NULL,
        date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    $db->exec('CREATE TABLE IF NOT EXISTS visiteurs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pays TEXT,
        ville TEXT,
        page TEXT,
        heure DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    return $db;
}
?>
