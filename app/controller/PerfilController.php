<?php

class PerfilController
{
  public function index()
  {
    $loader = new \Twig\Loader\FilesystemLoader('app/view');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('perfil.html');

    //Recuperar as postagens que tem no DB e mandar para a view.
    $objPost = Postagem::selecionaTodos();
    $parametros = array();
    $parametros['postagens'] = $objPost;

    $conteudo = $template->render($parametros);
    echo ($conteudo);
  }

  public function create()
  {
    $loader = new \Twig\Loader\FilesystemLoader('app/view');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('createPost.html');

    $parametros = array();

    $conteudo = $template->render($parametros);
    echo ($conteudo);
  }

  public function insert()
  {
    try {
      postagem::insert($_POST);

      echo '<script>alert("Publicação criada com sucesso!!")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=perfil&metodo=index"</script>';
    } catch (Exception $error) {
      echo '<script>alert("' . $error->getMessage() . '")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=perfil&metodo=create"</script>';

      //header("location: http://localhost/site-php-mvc/?pagina=perfil&metodo=create");
    }
  }

  public function change($paramId)
  {
    $loader = new \Twig\Loader\FilesystemLoader('app/view');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('update.html');

    $post = postagem::selecionaPostPorId($paramId);

    $parametros = array();
    $parametros['id'] = $post->id;
    $parametros['titulo'] = $post->titulo;
    $parametros['conteudo'] = $post->conteudo;

    $conteudo = $template->render($parametros);
    echo ($conteudo);
  }

  //Metodo resposavel pela alteração dos dados.
  public function update()
  {
    //Recebendo as informações por meio da requisição post da URL.
    // var_dump($_POST);
    try {
      postagem::update($_POST);

      echo '<script>alert("Publicação alterada com sucesso!!")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=perfil&metodo=index"</script>';
    } catch (Exception $error) {

      echo '<script>alert("' . $error->getMessage() . '")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=perfil&metodo=change&id=' . $_POST['id'] . '"</script>';
    }
  }

  public function delete($id)
  {
    //Recuperando via URL a informação do ID.
    $id = $_GET['id'];

    try {
      Postagem::delete($id);

      echo '<script>alert("Publicação deletada com sucesso!!")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=perfil&metodo=index"</script>';
    } catch (Exception $error) {

      echo '<script>alert("' . $error->getMessage() . '")</script>';

      echo '<script>location.href="http://localhost/site-php-mvc/?pagina=perfil&metodo=index"</script>';
    }
  }
}
