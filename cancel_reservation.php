<?php
require 'config.php';
require 'includes/auth_check.php';

$id      = (int)($_GET['id'] ?? 0);
$user_id = $_SESSION['user_id'];

// On supprime uniquement si la reservation appartient a l'utilisateur connecte
$stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);

header('Location: reservations.php?msg=cancel');
exit;
?>
