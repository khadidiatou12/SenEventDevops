<?php
require 'config.php';
require 'includes/admin_check.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$id]);

header('Location: events.php');
exit;
?>
