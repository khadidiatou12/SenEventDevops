<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SenEvent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">SenEvent</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <div class="navbar-nav ms-auto align-items-lg-center">
        <a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Accueil</a>
        <a class="nav-link" href="events.php"><i class="bi bi-calendar-event"></i> Evenements</a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a class="nav-link" href="reservations.php"><i class="bi bi-ticket-perforated"></i> Mes reservations</a>
          <?php if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
            <a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
            <a class="nav-link" href="add_event.php"><i class="bi bi-plus-circle"></i> Ajouter</a>
          <?php endif; ?>
          <a class="nav-link" href="logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <?= htmlspecialchars($_SESSION['user_nom']) ?><?php
              if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
              <span class="badge-admin ms-1">ADMIN</span><?php endif; ?>
          </a>
        <?php else: ?>
          <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
          <a class="nav-link" href="register.php"><i class="bi bi-person-plus"></i> Inscription</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="container mt-4">
