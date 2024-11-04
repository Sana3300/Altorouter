<?php

namespace App;
use PDO;
use PDOException;

class PostManager {
    
    public function getPosts(int $limit = 12): array
    {
        try {
            // Connexion à la base de données
            $pdo = new \PDO('mysql:host=localhost;dbname=tutoblog', 'root', 'root', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);
            
            // Préparation et exécution de la requête
            $stmt = $pdo->prepare('SELECT name, slug FROM post ORDER BY creat DESC LIMIT :limit');
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
    
            // Retourne le tableau des posts
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // Affiche l'erreur et retourne un tableau vide
            echo "Erreur lors de la récupération des posts : " . $e->getMessage();
            return [];
        }
    }
    
    
}
