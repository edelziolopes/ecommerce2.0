<?php

namespace Application\core;

class Controller
{

  public function model($model)
  {
    // CORREÇÃO: Removemos o require manual. O Autoloader carrega o model automaticamente.
    // require '../Application/models/' . $model . '.php';
    
    $classe = 'Application\\models\\' . $model;
    return new $classe();

  }

  public function view(string $view, $data = [])
  {
    // Views não são classes, então aqui continuamos usando require normalmente
    if (file_exists('../Application/views/' . $view . '.php')) {
      require '../Application/views/' . $view . '.php';
    } else {
      die("View não encontrada: " . $view);
    }
  }

  public function redirect(string $url)
  {
      $baseURL = 'http://' . $_SERVER['HTTP_HOST'] . '/';
      $fullURL = rtrim($baseURL, '/') . '/' . ltrim($url, '/');
      header('Location: ' . $fullURL);
      exit();
  }

  public function pageNotFound()
  {
    $this->view('erro404');
  }
}