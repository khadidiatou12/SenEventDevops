<?php
require 'config.php';
require 'includes/auth_check.php';

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT r.id, r.date_reservation, e.titre, e.lieu, e.date_event
    FROM reservations r
    JOIN events e ON r.event_id = e.id
    WHERE r.user_id = ?
    ORDER BY r.date_reservation DESC
");
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();
?>
<?php require 'includes/header.php'; ?>

<h2 class="page-title">Mes reservations</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'cancel'): ?>
  <div class="alert alert-warning"><i class="bi bi-info-circle"></i> Reservation annulee.</div>
<?php endif; ?>

<?php if (empty($reservations)): ?>
  <div class="text-center text-muted py-5">
    <i class="bi bi-ticket-perforated" style="font-size:3rem;"></i>
    <p class="mt-3">Vous n'avez aucune reservation.
      <a href="events.php">Voir les evenements</a></p>
  </div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr>
          <th>Evenement</th>
          <th>Lieu</th>
          <th>Date</th>
          <th>Reserve le</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $r): ?>
          <tr>
            <td class="fw-semibold"><?= htmlspecialchars($r['titre']) ?></td>
            <td><i class="bi bi-geo-alt text-muted"></i> <?= htmlspecialchars($r['lieu']) ?></td>
            <td><?= htmlspecialchars($r['date_event']) ?></td>
            <td class="text-muted"><small><?= htmlspecialchars($r['date_reservation']) ?></small></td>
            <td>
              <a href="cancel_reservation.php?id=<?= $r['id'] ?>"
                 class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Annuler cette reservation ?')">
                <i class="bi bi-x-lg"></i> Annuler
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
