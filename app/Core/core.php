<?php

class Core
{
  //trata em que pagina o visitante esta tentando acessar.
  public function start($urlGet)
  {
    if (isset($urlGet['metodo'])) {
      $acao = $urlGet['metodo'];
    } else {
      $acao = 'index';
    }

    if (isset($urlGet['pagina'])) {
      $controller = ucfirst($urlGet['pagina'] . 'Controller');
    } else {
      $controller = 'HomeController';
    }


    if (!class_exists($controller)) {
      $controller = 'Errorcontroller';
    }

    //Verificar se a url tem o parametro id.
    if (isset($urlGet['id']) && $urlGet['id'] != null) {
      $id = $urlGet['id'];
    } else {
      $id = null;
    }

    //objeto para a classe HomeController. Chama metodos de forma dinamica. urlGet por padrão ja é um array e vai estar mandando o id para a postController.
    //$urlGet['id']) ?? null
    call_user_func_array(array(new $controller, $acao), array($id));
    //array($id)
  }
}
