<?php

// Inclure l'autoloader de Composer pour utiliser Faker et les autres dépendances
require dirname(__DIR__) . '/vendor/autoload.php';

use Faker\Factory;

// Désactivation temporaire des clés étrangères pour vider les tables sans conflits
// //$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
// $pdo->exec('TRUNCATE TABLE post_category');
// $pdo->exec('TRUNCATE TABLE posts');
// $pdo->exec('TRUNCATE TABLE category');
// $pdo->exec('TRUNCATE TABLE user');
// $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// Initialisation de Faker pour générer des données fictives
$faker = Factory::create();

// Boucle pour insérer 60 posts fictifs dans la base de données
for ($i = 0; $i < 60; $i++) {
    $name = $faker->sentence(3); // Génère un titre de 3 mots
    $slug = $faker->slug; // Slug unique basé sur le titre
    $content = $faker->paragraphs(5, true); // Contenu de 5 paragraphes
    $creat = $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'); // Date dans les 2 dernières années

    // Préparation de la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO post (name, slug, content, creat) VALUES (:name, :slug, :content, :creat)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':creat' , $creat);
    $stmt->execute();
}

// Récupération des identifiants de tous les posts insérés
$postIds = $pdo->query("SELECT id FROM post")->fetchAll(PDO::FETCH_COLUMN);

// Préparation des requêtes pour insérer les catégories et lier les posts aux catégories
$categoryStmt = $pdo->prepare("INSERT INTO category (name, slug) VALUES (:name, :slug)");
$postCategoryStmt = $pdo->prepare("INSERT INTO post_category (post_id, category_id) VALUES (:post_id, :category_id)");

for ($i = 0; $i < 60; $i++) {
    // Générer les informations pour chaque catégorie
    $name = $faker->word;
    $slug = $faker->slug;
    $content = $faker->text;

    // Insertion de la catégorie dans la base de données
    $categoryStmt->execute([
        ':name' => $name,
        ':slug' => $slug,
        
    ]);

    // Récupérer l'identifiant de la catégorie insérée
    $categoryId = $pdo->lastInsertId();

    // Associer cette catégorie avec des posts choisis aléatoirement
    foreach ($postIds as $postId) {
        // Créer une association avec une probabilité de 50 %
        if ($faker->boolean(50)) { 
            $postCategoryStmt->execute([
                ':post_id' => $postId,
                ':category_id' => $categoryId
            ]);
        }
    }
  
    // Message de confirmation pour chaque catégorie ajoutée
   
}

$username = 'admin';
$password = password_hash('admin', PASSWORD_BCRYPT);
$userStmt = $pdo->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");

for($i = 1; $i < 5; $i++){
    // Insertion d'utilisateur dans la base de données
    $userStmt->execute([
        ':username' => $username,
        ':password' => $password,
    ]);
}

echo "Catégorie ajoutée avec ID : $categoryId et associations créées.<br>";