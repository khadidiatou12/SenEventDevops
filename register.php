<?php
require 'config.php';
$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom      = trim($_POST['nom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nom === '' || $email === '' || $password === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caracteres.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erreur = "Cet email est deja utilise.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$nom, $email, $hash]);
            $succes = "Compte cree avec succes ! Vous pouvez vous connecter.";
        }
    }
}
?>
<?php require 'includes/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="form-card">
      <div class="text-center mb-4">
        <div class="feature-icon"><i class="bi bi-person-plus"></i></div>
        <h2 class="page-title d-inline-block border-0">Inscription</h2>
      </div>

      <?php if ($erreur): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>
      <?php if ($succes): ?>
        <div class="alert alert-success">
          <i class="bi bi-check-circle"></i> <?= htmlspecialchars($succes) ?>
          <a href="login.php">Se connecter</a>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Nom</label>
          <input type="text" name="nom" class="form-control" placeholder="Votre nom" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="vous@exemple.com" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" placeholder="Au moins 6 caracteres" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg">S'inscrire</button>
        </div>
        <p class="text-center mt-3 mb-0 text-muted">
          Deja un compte ? <a href="login.php">Se connecter</a>
        </p>
      </form>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
