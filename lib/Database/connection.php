<?php

//Não permite que a classe seja instanciada diretamente.
abstract class Connection
{
  private static $conn;

  public static function getConn()
  {
    if (self::$conn == null) {
      //self para quando um atributo é estatico.
      self::$conn = new PDO('mysql: host=localhost; dbname=meubanco', 'root', '');
    }

    //ja retorna um obj da classe PDO
    return self::$conn;
  }
}
