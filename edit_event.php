<?php
require 'config.php';
require 'includes/admin_check.php';
$erreur = '';

$categories = ['Concert', 'Forum', 'Salon', 'Autre'];

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    header('Location: events.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date_event  = $_POST['date_event'] ?? '';
    $lieu        = trim($_POST['lieu'] ?? '');
    $categorie   = $_POST['categorie'] ?? 'Autre';
    $image       = $event['image']; // on garde l'ancienne par defaut

    if ($titre === '' || $date_event === '' || $lieu === '') {
        $erreur = "Le titre, la date et le lieu sont obligatoires.";
    } else {
        // Nouvelle image (optionnelle)
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $autorises = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($ext, $autorises)) {
                if (!is_dir('images')) { mkdir('images', 0777, true); }
                $nomFichier = 'event_' . time() . '_' . rand(100,999) . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $nomFichier)) {
                    $image = $nomFichier;
                }
            } else {
                $erreur = "Format d'image non autorise (jpg, png, gif, webp).";
            }
        }

        if ($erreur === '') {
            $stmt = $pdo->prepare(
                "UPDATE events SET titre = ?, description = ?, date_event = ?, lieu = ?, categorie = ?, image = ?
                 WHERE id = ?"
            );
            $stmt->execute([$titre, $description, $date_event, $lieu, $categorie, $image, $id]);
            header('Location: events.php');
            exit;
        }
    }
}
?>
<?php require 'includes/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="form-card">
      <h2 class="page-title">Modifier l'evenement</h2>

      <?php if ($erreur): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Titre</label>
          <input type="text" name="titre" class="form-control"
                 value="<?= htmlspecialchars($event['titre']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Categorie</label>
          <select name="categorie" class="form-control">
            <?php foreach ($categories as $c): ?>
              <option value="<?= $c ?>" <?= ($event['categorie'] === $c) ? 'selected' : '' ?>><?= $c ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date_event" class="form-control"
                 value="<?= htmlspecialchars($event['date_event']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Lieu</label>
          <input type="text" name="lieu" class="form-control"
                 value="<?= htmlspecialchars($event['lieu']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Image actuelle</label><br>
          <?php $imgAct = $event['image'] ? 'images/'.$event['image'] : 'images/default.jpg'; ?>
          <img src="<?= htmlspecialchars($imgAct) ?>" alt="" style="max-width:150px; border-radius:8px;"
               onerror="this.src='images/default.jpg'">
        </div>
        <div class="mb-3">
          <label class="form-label">Changer l'image (optionnel)</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Mettre a jour</button>
        <a href="events.php" class="btn btn-outline-secondary">Annuler</a>
      </form>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
