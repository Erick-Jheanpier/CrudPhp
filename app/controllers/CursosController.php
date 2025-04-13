<?php
// app/controllers/cursoController.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../models/Curso.php';

$curso = new Curso();
$method = $_SERVER['REQUEST_METHOD'];

try {
  switch($method) {
    case 'GET':
      if (isset($_GET['id'])) {
        $data = $curso->getById((int)$_GET['id']);
      } else {
        $data = $curso->getAll();
      }
      echo json_encode($data);
      break;
      
    case 'POST':
      $input = json_decode(file_get_contents('php://input'), true);
      if (isset($input['id_cursos']) && !empty($input['id_cursos'])) {
        $result = $curso->edit($input);
      } else {
        $result = $curso->add($input);
      }
      echo json_encode(["filas" => $result]);
      break;
      
    case 'DELETE':
      if(isset($_GET['id'])){
        $result = $curso->delete((int)$_GET['id']);
        echo json_encode(["filas" => $result]);
      } else {
        echo json_encode(["error" => "ID no especificado"]);
      }
      break;
      
    default:
      echo json_encode(["error" => "Método no soportado"]);
      break;
  }
} catch(Exception $e) {
  echo json_encode(["error" => $e->getMessage()]);
}
?>
