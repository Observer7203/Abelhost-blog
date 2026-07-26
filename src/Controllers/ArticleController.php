<?php

namespace App\Controllers;

use App\Models\Article;
use App\View;

Class ArticleController {
    public function show(int $id): void {

        Article::IncrementViews($id);
        $article = Article::getById($id);
        $categories = Article::getCategories($id);
        $similarArticles = Article::getSimilar($id);

        $view = new View();
        $view->render('article.tpl', ['article' => $article, 'categories' => $categories, 'similarArticles' => $similarArticles]);

    }
}