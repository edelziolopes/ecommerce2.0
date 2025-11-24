<?php

use Application\core\Controller;

class Imagem extends Controller
{
  public function index()
  {     
    $Imagens = $this->model('Imagens');
    $Imagem = $Imagens::findAll();
    $this->view('imagem/index', [
      'imagens' => $Imagem
    ]);
  }

}
