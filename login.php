<?php
require 'config.php';
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_nom']  = $user['nom'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<?php require 'includes/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="form-card">
      <div class="text-center mb-4">
        <div class="feature-icon"><i class="bi bi-box-arrow-in-right"></i></div>
        <h2 class="page-title d-inline-block border-0">Connexion</h2>
      </div>

      <?php if ($erreur): ?>
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="vous@exemple.com" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
        </div>
        <p class="text-center mt-3 mb-0 text-muted">
          Pas encore de compte ? <a href="register.php">Creer un compte</a>
        </p>
      </form>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
