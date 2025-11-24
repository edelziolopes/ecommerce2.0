<?php

use Application\core\Controller;

class Home extends Controller
{
  public function index()
  {
    $Produtos = $this->model('Produtos');
    $Produto = $Produtos::findIndex();        
    $Categorias = $this->model('Categorias');
    $Categoria = $Categorias::findAll();
    $Imagens = $this->model('Imagens');
    $Imagem = $Imagens::findAll();
    $this->view('home/index', [
      'produtos' => $Produto, 
      'categorias' => $Categoria,
      'imagens' => $Imagem
    ]);
  }



}
