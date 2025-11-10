<?php
// api/products.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

// CORS for development
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
function json($data){ echo json_encode($data); exit; }

if ($method === 'GET') {
  if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    json($stmt->fetch() ?: []);
  }
  $sql = 'SELECT * FROM products WHERE 1=1';
  $params = [];
  if (!empty($_GET['motif'])) { $sql .= ' AND motif = ?'; $params[] = $_GET['motif']; }
  if (!empty($_GET['size'])) { $sql .= ' AND size = ?'; $params[] = $_GET['size']; }
  if (!empty($_GET['q'])) { $sql .= ' AND (name LIKE ? OR description LIKE ?)'; $params[] = '%'.$_GET['q'].'%'; $params[] = '%'.$_GET['q'].'%'; }
  $stmt = $pdo->prepare($sql.' ORDER BY id DESC');
  $stmt->execute($params);
  json($stmt->fetchAll());
}

if ($method === 'POST') {
  // create product (multipart/form-data)
  $name = $_POST['name'] ?? null;
  $motif = $_POST['motif'] ?? null;
  $size = $_POST['size'] ?? null;
  $price = (int)($_POST['price'] ?? 0);
  $stock = (int)($_POST['stock'] ?? 0);
  $rating = (float)($_POST['rating'] ?? 0);
  $description = $_POST['description'] ?? null;

  $imagePath = null;
  if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $f = $_FILES['image'];
    $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp'];
    if (!in_array(strtolower($ext), $allowed)) json(['error'=>'invalid_image']);
    $newName = uniqid('prod_') . '.' . $ext;
    $dest = __DIR__ . '/../uploads/' . $newName;
    if (!move_uploaded_file($f['tmp_name'], $dest)) json(['error'=>'upload_failed']);
    $imagePath = 'uploads/' . $newName;
  }

  $stmt = $pdo->prepare('INSERT INTO products (name,motif,size,price,stock,rating,image,description) VALUES (?,?,?,?,?,?,?,?)');
  $stmt->execute([$name,$motif,$size,$price,$stock,$rating,$imagePath,$description]);
  json(['success'=>true, 'id' => $pdo->lastInsertId()]);
}

if ($method === 'PUT' || $method === 'DELETE') {
  parse_str(file_get_contents('php://input'), $put);
}

if ($method === 'PUT') {
  $id = $put['id'] ?? null;
  if (!$id) json(['error'=>'missing_id']);
  $fields = [];
  $params = [];
  foreach (['name','motif','size','price','stock','rating','description','image'] as $f) {
    if (isset($put[$f])) { $fields[] = "$f = ?"; $params[] = $put[$f]; }
  }
  if (!$fields) json(['error'=>'no_fields']);
  $params[] = $id;
  $sql = 'UPDATE products SET ' . implode(',', $fields) . ' WHERE id = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  json(['success'=>true]);
}

if ($method === 'DELETE') {
  $id = $put['id'] ?? null;
  if (!$id) json(['error'=>'missing_id']);
  $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
  $stmt->execute([$id]);
  json(['success'=>true]);
}
