<?php

namespace Application\Controllers;

use Application\Models\Article as ArticleModel;

class Article {
  public function actionAll() {
    $items = ArticleModel::findAll();
    $view = new \View();
    $view->items = $items;
    $view->display('article/all.php');
  }
  
  public function actionOne() {
    $id = $_GET['id'];
    $item = ArticleModel::findOneById($id);
    $view = new \View();
    $view->item = $item;
    $view->display('article/one.php');
  }
}