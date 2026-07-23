<?php
require 'config.php';

$isAdmin = (($_SESSION['user_role'] ?? 'user') === 'admin');

// --- Recherche et filtre ---
$recherche = trim($_GET['q'] ?? '');
$filtre    = $_GET['cat'] ?? 'Tous';

$sql = "SELECT * FROM events WHERE 1=1";
$params = [];

if ($recherche !== '') {
    $sql .= " AND (titre LIKE ? OR description LIKE ? OR lieu LIKE ?)";
    $like = "%$recherche%";
    $params[] = $like; $params[] = $like; $params[] = $like;
}
if ($filtre !== 'Tous' && $filtre !== '') {
    $sql .= " AND categorie = ?";
    $params[] = $filtre;
}
$sql .= " ORDER BY date_event ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll();

// Liste des categories disponibles pour les boutons de filtre
$categories = ['Tous', 'Concert', 'Forum', 'Salon'];
?>
<?php require 'includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="page-title mb-0">Evenements</h2>
  <?php if ($isAdmin): ?>
    <a href="add_event.php" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Ajouter un evenement
    </a>
  <?php endif; ?>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'reserve'): ?>
  <div class="alert alert-success d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
    <span>Reservation effectuee avec succes !</span>
  </div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] === 'denied'): ?>
  <div class="alert alert-danger"><i class="bi bi-shield-lock"></i> Acces reserve a l'administrateur.</div>
<?php endif; ?>

<!-- Barre de recherche -->
<form method="get" class="mb-3">
  <div class="input-group">
    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
    <input type="text" name="q" class="form-control" placeholder="Rechercher un evenement..."
           value="<?= htmlspecialchars($recherche) ?>">
    <input type="hidden" name="cat" value="<?= htmlspecialchars($filtre) ?>">
    <button class="btn btn-primary" type="submit">Rechercher</button>
    <?php if ($recherche !== ''): ?>
      <a href="events.php" class="btn btn-outline-secondary">Effacer</a>
    <?php endif; ?>
  </div>
</form>

<!-- Filtres par categorie -->
<div class="mb-4">
  <?php foreach ($categories as $cat): ?>
    <a href="events.php?cat=<?= urlencode($cat) ?><?= $recherche ? '&q='.urlencode($recherche) : '' ?>"
       class="btn btn-sm <?= ($filtre === $cat) ? 'btn-primary' : 'btn-outline-primary' ?> me-1 mb-1">
      <?= htmlspecialchars($cat) ?>
    </a>
  <?php endforeach; ?>
</div>

<?php if (empty($events)): ?>
  <div class="text-center text-muted py-5">
    <i class="bi bi-calendar-x" style="font-size:3rem;"></i>
    <p class="mt-3">Aucun evenement trouve<?= $recherche ? ' pour "'.htmlspecialchars($recherche).'"' : '' ?>.</p>
  </div>
<?php else: ?>
  <div class="row g-4">
    <?php foreach ($events as $e): ?>
      <div class="col-md-4">
        <div class="card event-card h-100">
          <?php
            $img = $e['image'] ? 'images/'.$e['image'] : 'images/default.jpg';
          ?>
          <img src="<?= htmlspecialchars($img) ?>" class="event-img" alt="<?= htmlspecialchars($e['titre']) ?>"
               onerror="this.src='images/default.jpg'">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h5 class="card-title mb-0"><?= htmlspecialchars($e['titre']) ?></h5>
              <span class="badge-cat"><?= htmlspecialchars($e['categorie']) ?></span>
            </div>
            <div class="mb-2 text-muted">
              <span class="card-subtitle"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($e['lieu']) ?></span><br>
              <span class="card-subtitle"><i class="bi bi-calendar3"></i> <?= htmlspecialchars($e['date_event']) ?></span>
            </div>
            <p class="card-text"><?= nl2br(htmlspecialchars($e['description'])) ?></p>
          </div>
          <div class="card-footer bg-white border-0 pb-3">
            <?php if (isset($_SESSION['user_id'])): ?>
              <a href="reserve.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-ticket-perforated"></i> Reserver
              </a>
              <?php if ($isAdmin): ?>
                <a href="edit_event.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-pencil"></i> Modifier
                </a>
                <a href="delete_event.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Supprimer cet evenement ?')">
                  <i class="bi bi-trash"></i> Supprimer
                </a>
              <?php endif; ?>
            <?php else: ?>
              <a href="login.php" class="btn btn-sm btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour reserver
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
