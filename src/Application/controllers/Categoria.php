<?php

use Application\core\Controller;

class Categoria extends Controller
{
  public function index()
  {     
    $Categorias = $this->model('Categorias');
    $Categoria = $Categorias::findAll();
    $this->view('categoria/index', [
      'categorias' => $Categoria
    ]);
  }

}
