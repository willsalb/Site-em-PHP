<?php

//conectar com o DB e traz os dados da postagem
class Postagem
{
  //static para acessar o metodo sem criar uma instancia da classe.
  public static function selecionaTodos()
  {
    //PDO faz a validação dos dados quando for enviar para o DB.
    $conex = Connection::getConn();

    // var_dump($conex);

    $sql = 'SELECT * FROM postagem ORDER BY id DESC';
    //prepare-> faz a execução do codigo sql(validação do que ta indo pra query)
    $sql = $conex->prepare($sql);
    $sql->execute();

    //Lista todos os resultados da preparação do codigo sql.
    // var_dump($sql->fetchAll());

    $resultado = array();

    //Pega os registros no banco e converte em um objeto.
    while ($row = $sql->fetchObject('Postagem')) {
      $resultado[] = $row;
    }

    if (!$resultado) {
      throw new Exception("Nenhum banco encontrado!!");
    }

    return $resultado;
  }

  public static function selecionaPostPorId($idPost)
  {
    $conex = Connection::getConn();

    //id passado do parametro da function.
    $sql = "SELECT * FROM postagem WHERE id = :id";
    $sql = $conex->prepare($sql);
    //Trocando o valor do ':id' pelo valor que vier como parametro, e apontando o valor como inteiro.
    $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
    $sql->execute();

    //Criando um objeto da classe postagem.
    $resultado = $sql->fetchObject('Postagem');

    if (!$resultado) {
      throw new Exception("Nenhum banco encontrado!!");
    } else {
      $resultado->comentarios = Comentario::selecionarComentPorId($resultado->id);
    }

    return $resultado;
  }

  public static function insert($dadosPost)
  {

    if (empty($dadosPost['titulo']) || empty($dadosPost['conteudo'])) {
      throw new Exception("Preencha todos os campos!!");

      return false;
    }

    $conex = Connection::getConn();

    //BindValue->PDO faz uma validação para prevenir uma injeção de SQL
    // $sql = 'INSERT TO (titulo, conteudo) VALUES (:tit, :cont)';
    $sql = 'INSERT INTO postagem (titulo, conteudo) VALUES (:tit, :cont)';
    $sql = $conex->prepare($sql);
    $sql->bindValue(':tit', $dadosPost['titulo']);
    $sql->bindValue(':cont', $dadosPost['conteudo']);
    //Guarda o dado como uma informação booleana.
    $resultado = $sql->execute();

    if ($resultado == false) {
      throw new Exception("Falha ao criar a publicação!!");

      return false;
    }

    return true;
  }

  //Recebendo os parametros da requisição _POST.
  public static function update($params)
  {
    $conex = Connection::getConn();

    $sql = 'UPDATE postagem SET titulo = :tit, conteudo = :cont WHERE id = :id';
    $sql = $conex->prepare($sql);
    $sql->bindValue(':tit', $params['titulo']);
    $sql->bindValue(':cont', $params['conteudo']);
    $sql->bindValue(':id', $params['id']);
    $resultado = $sql->execute();

    if ($resultado == 0) {
      throw new Exception("Falha ao alterar a publicação!!");

      return false;
    }

    return true;
  }

  public static function delete($id)
  {
    $conex = Connection::getConn();

    $sql = 'DELETE FROM postagem WHERE id = :id';
    $sql = $conex->prepare($sql);
    $sql->bindValue(':id', $id);
    $resultado = $sql->execute();

    if ($resultado == 0) {
      throw new Exception("Falha ao deletar a publicação!!");

      return false;
    }

    return true;
  }
}
