<?php
require 'config.php';
require 'includes/admin_check.php';

// Compter les enregistrements de chaque table
$nbUsers        = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$nbEvents       = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$nbReservations = $pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn();

// Dernieres reservations pour un apercu
$stmt = $pdo->query("
    SELECT u.nom AS user_nom, e.titre, r.date_reservation
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    JOIN events e ON r.event_id = e.id
    ORDER BY r.date_reservation DESC
    LIMIT 5
");
$dernieres = $stmt->fetchAll();
?>
<?php require 'includes/header.php'; ?>

<h2 class="page-title">Tableau de bord</h2>

<div class="row g-4 mb-5">
  <div class="col-md-4">
    <div class="card stat-card stat-teal h-100">
      <div class="card-body text-center py-4">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div class="stat-number"><?= $nbUsers ?></div>
        <div class="stat-label">Utilisateurs</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card stat-blue h-100">
      <div class="card-body text-center py-4">
        <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
        <div class="stat-number"><?= $nbEvents ?></div>
        <div class="stat-label">Evenements</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card stat-amber h-100">
      <div class="card-body text-center py-4">
        <div class="stat-icon"><i class="bi bi-ticket-perforated"></i></div>
        <div class="stat-number"><?= $nbReservations ?></div>
        <div class="stat-label">Reservations</div>
      </div>
    </div>
  </div>
</div>

<h4 class="mb-3"><i class="bi bi-clock-history"></i> Dernieres reservations</h4>
<?php if (empty($dernieres)): ?>
  <p class="text-muted">Aucune reservation pour le moment.</p>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr><th>Utilisateur</th><th>Evenement</th><th>Date</th></tr>
      </thead>
      <tbody>
        <?php foreach ($dernieres as $d): ?>
          <tr>
            <td class="fw-semibold"><?= htmlspecialchars($d['user_nom']) ?></td>
            <td><?= htmlspecialchars($d['titre']) ?></td>
            <td class="text-muted"><small><?= htmlspecialchars($d['date_reservation']) ?></small></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
