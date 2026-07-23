<?php
require 'config.php';
require 'includes/admin_check.php';
$erreur = '';

$categories = ['Concert', 'Forum', 'Salon', 'Autre'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date_event  = $_POST['date_event'] ?? '';
    $lieu        = trim($_POST['lieu'] ?? '');
    $categorie   = $_POST['categorie'] ?? 'Autre';
    $image       = null;

    if ($titre === '' || $date_event === '' || $lieu === '') {
        $erreur = "Le titre, la date et le lieu sont obligatoires.";
    } else {
        // Upload de l'image (optionnel)
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
                "INSERT INTO events (titre, description, date_event, lieu, categorie, image)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$titre, $description, $date_event, $lieu, $categorie, $image]);
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
      <h2 class="page-title">Ajouter un evenement</h2>

      <?php if ($erreur): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Titre</label>
          <input type="text" name="titre" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Categorie</label>
          <select name="categorie" class="form-control">
            <?php foreach ($categories as $c): ?>
              <option value="<?= $c ?>"><?= $c ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date_event" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Lieu</label>
          <input type="text" name="lieu" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Image (optionnel)</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Enregistrer</button>
        <a href="events.php" class="btn btn-outline-secondary">Annuler</a>
      </form>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
