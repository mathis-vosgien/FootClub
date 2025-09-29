<?php
// Configuration de la base de données pour MAMP
$host = 'localhost';
$port = 8889; // Port MySQL de MAMP
$dbName = 'footclub';
$user = 'root';
$pass = 'root';

// Initialisation de la variable de connexion
$connexion = null;

try {
    // Création de la connexion PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8";
    $connexion = new PDO($dsn, $user, $pass);
    
    // Configuration des options PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Message de succès (optionnel - à supprimer en production)
    // echo "✅ Connexion réussie à la base de données '$dbName'<br>";
    
} catch(PDOException $e) {
    // En cas d'erreur, arrêter complètement l'exécution
    die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
}

// La variable $connexion est maintenant disponible dans tous les fichiers qui incluent db.php
?>