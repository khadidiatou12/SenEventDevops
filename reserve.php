<?php
require 'config.php';
require 'includes/auth_check.php';

$event_id = (int)($_GET['id'] ?? 0);
$user_id  = $_SESSION['user_id'];

// Verifier que l'evenement existe
$stmt = $pdo->prepare("SELECT id FROM events WHERE id = ?");
$stmt->execute([$event_id]);
if (!$stmt->fetch()) {
    header('Location: events.php');
    exit;
}

// Eviter les doublons
$stmt = $pdo->prepare("SELECT id FROM reservations WHERE user_id = ? AND event_id = ?");
$stmt->execute([$user_id, $event_id]);

if (!$stmt->fetch()) {
    $stmt = $pdo->prepare("INSERT INTO reservations (user_id, event_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $event_id]);
}

header('Location: events.php?msg=reserve');
exit;
?>
