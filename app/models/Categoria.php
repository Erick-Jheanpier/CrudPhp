<?php
// app/models/Categoria.php
require_once __DIR__ . '/../config/Database.php';

class Categoria {
  private $conexion;

  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  
  // Devuelve todas las categorías
  public function getAll(): array {
    $sql = "SELECT * FROM categoria";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  // Inserta una categoría (usando procedimiento almacenado)
  public function add(string $categoria): int {
    $sql = "CALL insertar_categoria(?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$categoria]);
    return $stmt->rowCount();
  }
  
  // Actualiza una categoría
  public function edit(int $id_categoria, string $categoria): int {
    $sql = "CALL actualizar_categoria(?,?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id_categoria, $categoria]);
    return $stmt->rowCount();
  }

  // Elimina una categoría
  public function delete(int $id_categoria): int {
    $sql = "CALL eliminar_categoria(?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id_categoria]);
    return $stmt->rowCount();
  }

  // Obtiene una categoría por su ID
  public function getById(int $id_categoria): array {
    $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id_categoria]);
    return $stmt->fetch();
  }
}
?>


