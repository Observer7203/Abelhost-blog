<?php

namespace App\Models;

use App\Database;
use PDO;

class Category {
    
    public static function getAll(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY title ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        return $category ?: null;
    }

    public static function getWithArticles(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query(
            "SELECT c.*, COUNT(ac.article_id) AS article_count
            FROM categories c
            LEFT JOIN article_category ac ON c.id = ac.category_id
            GROUP BY c.id
            ORDER BY c.title ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}