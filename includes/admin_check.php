<?php
// A inclure en haut des pages reservees a l'administrateur
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// L'utilisateur doit etre connecte
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Et avoir le role admin
if (($_SESSION['user_role'] ?? 'user') !== 'admin') {
    header('Location: events.php?msg=denied');
    exit;
}
?>
