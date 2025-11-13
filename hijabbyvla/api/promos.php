<?php
// api/promos.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
function json($d){ echo json_encode($d); exit; }

if ($method === 'GET'){
  if (isset($_GET['id'])){ $stmt = $pdo->prepare('SELECT * FROM promos WHERE id=?'); $stmt->execute([$_GET['id']]); json($stmt->fetch()); }
  $stmt = $pdo->query('SELECT * FROM promos ORDER BY id DESC'); json($stmt->fetchAll());
}

if ($method === 'POST'){
  $data = json_decode(file_get_contents('php://input'), true);
  if (!$data) json(['error'=>'invalid_json']);
  $stmt = $pdo->prepare('INSERT INTO promos (code,description,discount_type,discount_value,active,start_date,end_date) VALUES (?,?,?,?,?,?,?)');
  $stmt->execute([$data['code'],$data['description'],$data['discount_type'],$data['discount_value'],$data['active'],$data['start_date'],$data['end_date']]);
  json(['success'=>true, 'id' => $pdo->lastInsertId()]);
}

if ($method === 'PUT'){
  parse_str(file_get_contents('php://input'), $put);
  if (empty($put['id'])) json(['error'=>'missing_id']);
  $fields = []; $params=[];
  foreach(['code','description','discount_type','discount_value','active','start_date','end_date'] as $f){ if (isset($put[$f])){ $fields[] = "$f = ?"; $params[] = $put[$f]; }}
  $params[] = $put['id'];
  $sql = 'UPDATE promos SET '.implode(',', $fields).' WHERE id = ?';
  $pdo->prepare($sql)->execute($params);
  json(['success'=>true]);
}

if ($method === 'DELETE'){
  parse_str(file_get_contents('php://input'), $put);
  if (empty($put['id'])) json(['error'=>'missing_id']);
  $pdo->prepare('DELETE FROM promos WHERE id = ?')->execute([$put['id']]);
  json(['success'=>true]);
}
