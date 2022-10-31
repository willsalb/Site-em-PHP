<?php

class Comentario
{
  public static function selecionarComentPorId($idpost)
  {
    $conex = Connection::getConn();
    //Igual a informação que vier do param(idpost)
    $sql = 'SELECT * FROM comentarios WHERE id_postagem = :id';
    $sql = $conex->prepare($sql);
    $sql->bindValue(':id', $idpost, PDO::PARAM_INT);
    $sql->execute();

    $resultado = array();

    while ($row = $sql->fetchObject("Comentario")) {
      $resultado[] = $row;
    }

    return $resultado;
  }

  public static function insert($reqPost)
  {
    $conex = Connection::getConn();

    $sql = 'INSERT INTO comentarios (nome, mensagem, id_postagem) VALUES (:nom, :msg, :idp)';
    $sql = $conex->prepare($sql);
    $sql->bindValue(':nom', $reqPost['nome']);
    $sql->bindValue(':msg', $reqPost['msg']);
    $sql->bindValue(':idp', $reqPost['id']);
    $sql->execute();

    //Retorna o numero de linhas afetadas pelo ultimo comando SQL;
    if ($sql->rowCount()) {
      return true;
    } else {
      throw new Exception('Falha na inserção!!');
    }
  }
}
