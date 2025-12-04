<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2>Olá, <?php echo $user['name'] ?? 'visitante'; ?> 👋</h2>
    <p class="text-muted">Bem-vindo ao TravelTrack</p>
  </div>
  <div class="text-end">
    <?php if (!empty($_SESSION['user_id'])): ?>
      <div class="points-badge">Pts <span><?php echo $user['points'] ?? 0; ?></span></div>
    <?php endif; ?>
    <a class="btn btn-outline-success mt-2" href="index.php?page=qr">Escanear QR Code</a>
  </div>
</div>

<h4>Locais próximos</h4>
<div class="row">
  <?php foreach ($places as $p): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card place-card mb-3">
        <img src="public/images/place-placeholder.jpg" class="card-img-top" alt="<?php echo $p['name']; ?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo $p['name']; ?></h5>
          <p class="card-text text-muted"><?php echo $p['city']; ?> - <?php echo $p['state']?></p>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="badge bg-success">Sustentabilidade: <?php echo $p['sustainability_level']; ?></span>
              <span class="badge bg-info text-dark ms-1"><?php echo $p['points']; ?> pts</span>
            </div>
            <a href="index.php?page=place&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-success">Ver Detalhes</a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<h4 class="mt-4">Ranking semanal</h4>
<div class="list-group mb-4">
  <?php foreach ($ranking as $r): ?>
    <div class="list-group-item d-flex justify-content-between align-items-center">
      <div><strong><?php echo $r['nome']; ?></strong> <small class="text-muted">Top</small></div>
      <div class="fw-bold"><?php echo $r['total']; ?> pts</div>
    </div>
  <?php endforeach; ?>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
