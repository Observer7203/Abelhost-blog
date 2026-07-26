<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\View;

class CategoryController {
    public function show(int $id): void {
        $category = Category::getById($id);

        if (!$category) { http_response_code(404); exit('Category not found'); }

        $sort = $_GET['sort'] ?? 'date';
        $page = (int) ($_GET['page'] ?? 1);
        if ($page < 1) {
            $page = 1;
        }
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $articles = Article::getByCategory($id, $perPage, $sort, $offset);
        $total = Article::countByCategory($id);
        $totalPages = (int) ceil($total / $perPage);

        $view = new View();
        $view->render('category.tpl', [
            'category' => $category,
            'articles' => $articles,
            'sort' => $sort,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
