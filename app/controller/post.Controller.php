<?php

class PostController
{
  public function index($params)
  {
    try {
      $post = Postagem::selecionaPostPorId($params);

      $loader = new \Twig\Loader\FilesystemLoader('app/view');
      $twig = new \Twig\Environment($loader);
      $template = $twig->load('single.html');

      $parametros = array();
      //informar os dados para passar para view.
      $parametros['id'] = $post->id;
      $parametros['titulo'] = $post->titulo;
      $parametros['conteudo'] = $post->conteudo;
      $parametros['comentarios'] = $post->comentarios;

      //Renderiza a view junto com os parametros
      $conteudo = $template->render($parametros);
      echo $conteudo;

      // var_dump($colectPost);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function addComent()
  {
    try {
      //Recebe os dados do form da single.html pela requisição POST;
      Comentario::insert($_POST);

      //Vai atualizar a tela e pega os dados novamente do banco de dados.
      header('Location: http://localhost/site-php-mvc/?pagina=post&id=' . $_POST['id']);
    } catch (Exception $error) {

      echo '<script>alert("' . $error->getMessage() . '")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=post&id=' . $_POST['id'] . '"</script>';
    }
  }
}
