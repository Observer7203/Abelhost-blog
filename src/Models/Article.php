<?php

namespace App\Models;

use App\Database;
use PDO;

class Article {
    
    public static function getAll(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    public static function getById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return $article ?: null;
        }

    public static function getByCategory(int $id): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(
            "SELECT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = :category_id
            ORDER BY a.created_at DESC"
        );
        $stmt->bindParam(':category_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getSimilar(int $id, int $limit = 3): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(
            "SELECT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id IN (
                SELECT category_id FROM article_category WHERE article_id = :aid
            ) AND a.id != :aid2
            GROUP BY a.id
            ORDER BY a.created_at DESC
            LIMIT " . (int) $limit
        );
        $stmt->bindValue(':aid', $id, PDO::PARAM_INT);
        $stmt->bindValue(':aid2', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
