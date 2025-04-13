<?php
// app/config/Database.php

class Database {
  private static $host = "localhost";
  private static $dbname = "curso";
  private static $username = "root";
  // Define la contraseña correcta si la requiere tu instalación
  private static $password = "Erick2000";  
  private static $charset = "utf8mb4";
  private static $conexion = null;

  public static function getConexion(){
    if (self::$conexion === null){
      try {
        $DSN = "mysql:host=" . self::$host . ";port=3306;dbname=" . self::$dbname . ";charset=" . self::$charset;
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ];
        self::$conexion = new PDO($DSN, self::$username, self::$password, $options);
      } catch(PDOException $e) {
        // En desarrollo, mostrar error; en producción, registrar
        throw new PDOException($e->getMessage());
      }
    }
    return self::$conexion;
  }

  public static function closeConexion(){
    self::$conexion = null;
  }
}
?>


