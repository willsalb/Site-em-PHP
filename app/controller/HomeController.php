<?php

class HomeController
{
  public function index()
  {
    try {
      // echo 'teste';

      $colectPost = Postagem::selecionaTodos();

      $loader = new \Twig\Loader\FilesystemLoader('app/view');
      $twig = new \Twig\Environment($loader);
      $template = $twig->load('home.html');

      $parametros = array();
      //informar os dados para passar para view.
      $parametros['postagens'] = $colectPost;

      //Renderiza a view junto com os parametros
      $conteudo = $template->render($parametros);
      echo $conteudo;

      // var_dump($colectPost);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
}
