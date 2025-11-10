<?php
// api/orders.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
function json($d){ echo json_encode($d); exit; }

if ($method === 'GET') {
  if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    json($stmt->fetch());
  }
  $stmt = $pdo->query('SELECT * FROM orders ORDER BY id DESC');
  json($stmt->fetchAll());
}

if ($method === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  if (!$data) json(['error'=>'invalid_json']);
  $customer_name = $data['customer_name'] ?? '';
  $phone = $data['phone'] ?? '';
  $address = $data['address'] ?? '';
  $items = $data['items'] ?? [];
  $total = (int)($data['total'] ?? 0);

  $pdo->beginTransaction();
  $stmt = $pdo->prepare('INSERT INTO orders (customer_name,phone,address,total) VALUES (?,?,?,?)');
  $stmt->execute([$customer_name,$phone,$address,$total]);
  $orderId = $pdo->lastInsertId();
  $ins = $pdo->prepare('INSERT INTO order_items (order_id,product_id,qty,price) VALUES (?,?,?,?)');
  foreach ($items as $it) {
    $ins->execute([$orderId, $it['product_id'], $it['qty'], $it['price']]);
  }
  $pdo->commit();
  json(['success'=>true, 'order_id'=>$orderId]);
}

if ($method === 'PUT') {
  parse_str(file_get_contents('php://input'), $put);
  if (empty($put['id']) || empty($put['status'])) json(['error'=>'missing']);
  $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
  $stmt->execute([$put['status'], $put['id']]);
  json(['success'=>true]);
}
