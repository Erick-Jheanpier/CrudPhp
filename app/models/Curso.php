<?php
// app/models/Curso.php
require_once __DIR__ . '/../config/Database.php';

class Curso {
  private $conexion;

  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  
  // Devuelve todos los cursos (unidos a sus categorías)
  public function getAll(): array {
    $sql = "SELECT c.id_cursos, c.titulo, c.duracion_horas, c.nivel, c.precio, c.fecha_inicio, cat.categoria 
            FROM cursos c 
            INNER JOIN categoria cat ON c.id_categoria = cat.id_categoria";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  // Inserta un curso (procedimiento almacenado)
  public function add(array $params): int {
    $sql = "CALL insertar_cursos(?,?,?,?,?,?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
      $params["titulo"],
      $params["duracion_horas"],
      $params["nivel"],
      $params["precio"],
      $params["fecha_inicio"],
      $params["id_categoria"]
    ]);
    return $stmt->rowCount();
  }

  // Actualiza un curso existente
  public function edit(array $params): int {
    $sql = "CALL actualizar_curso(?,?,?,?,?,?,?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
      $params["id_cursos"],
      $params["titulo"],
      $params["duracion_horas"],
      $params["nivel"],
      $params["precio"],
      $params["fecha_inicio"],
      $params["id_categoria"]
    ]);
    return $stmt->rowCount();
  }

  // Elimina un curso
  public function delete(int $id_cursos): int {
    $sql = "CALL eliminar_curso(?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id_cursos]);
    return $stmt->rowCount();
  }

  // Obtiene un curso por ID
  public function getById(int $id_cursos): array {
    $sql = "SELECT c.id_cursos, c.titulo, c.duracion_horas, c.nivel, c.precio, c.fecha_inicio, 
                   cat.id_categoria, cat.categoria
            FROM cursos c 
            INNER JOIN categoria cat ON c.id_categoria = cat.id_categoria
            WHERE c.id_cursos = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id_cursos]);
    return $stmt->fetch();
  }
}
?>


