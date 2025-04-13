<?php
// app/controllers/categoriaController.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../models/Categoria.php';

$categoria = new Categoria();
$method = $_SERVER['REQUEST_METHOD'];

try {
  switch($method) {
    case 'GET':
      if (isset($_GET['id'])) {
        $data = $categoria->getById((int)$_GET['id']);
      } else {
        $data = $categoria->getAll();
      }
      echo json_encode($data);
      break;
    
    case 'POST':
      $input = json_decode(file_get_contents('php://input'), true);
      if (isset($input['id_categoria'])) {
        $result = $categoria->edit($input['id_categoria'], $input['categoria']);
      } else {
        $result = $categoria->add($input['categoria']);
      }
      echo json_encode(["filas" => $result]);
      break;
    
    case 'DELETE':
      if(isset($_GET['id'])){
        $result = $categoria->delete((int)$_GET['id']);
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

