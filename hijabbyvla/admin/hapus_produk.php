<?php
require_once("../config.php");
$id = $_GET["id"];
$pdo->query("DELETE FROM products WHERE id=$id");
header("Location: dashboard.php");
