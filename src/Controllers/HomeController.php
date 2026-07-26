<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\View;

class HomeController {
    public function index(): void
    {

        $categories = Category::getWithArticles();
        foreach ($categories as $key => $cat) {
            $categories[$key]['articles'] = Article::getByCategory($cat['id'], 3);
        }

        $view = new View();
        $view->render('home.tpl', [
            'categories' => $categories,
        ]);
    }
}

