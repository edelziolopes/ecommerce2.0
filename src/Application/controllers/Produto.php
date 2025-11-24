<?php

use Application\core\Controller;

class Produto extends Controller
{
  public function index()
  {
    $this->view('produto/index');
  }

}
