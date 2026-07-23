<?php require 'config.php'; ?>
<?php require 'includes/header.php'; ?>

<div class="se-hero mb-5">
  <h1>Bienvenue sur SenEvent</h1>
  <p class="col-md-8 mx-auto">
    La plateforme simple et moderne pour decouvrir et reserver vos evenements au Senegal.
  </p>
  <div class="mt-4">
    <a href="events.php" class="btn btn-primary btn-lg px-4">
      <i class="bi bi-calendar-event"></i> Voir les evenements
    </a>
    <?php if (!isset($_SESSION['user_id'])): ?>
      <a href="register.php" class="btn btn-outline-secondary btn-lg px-4">
        <i class="bi bi-person-plus"></i> Creer un compte
      </a>
    <?php endif; ?>
  </div>
</div>

<div class="row text-center g-4 mb-4">
  <div class="col-md-4">
    <div class="card h-100"><div class="card-body p-4">
      <div class="feature-icon"><i class="bi bi-search"></i></div>
      <h5 class="card-title">Decouvrir</h5>
      <p class="card-text text-muted">Parcourez la liste des evenements a venir pres de chez vous.</p>
    </div></div>
  </div>
  <div class="col-md-4">
    <div class="card h-100"><div class="card-body p-4">
      <div class="feature-icon"><i class="bi bi-ticket-perforated"></i></div>
      <h5 class="card-title">Reserver</h5>
      <p class="card-text text-muted">Reservez votre place en un seul clic, simplement.</p>
    </div></div>
  </div>
  <div class="col-md-4">
    <div class="card h-100"><div class="card-body p-4">
      <div class="feature-icon"><i class="bi bi-gear"></i></div>
      <h5 class="card-title">Gerer</h5>
      <p class="card-text text-muted">Les administrateurs creent et gerent les evenements.</p>
    </div></div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
