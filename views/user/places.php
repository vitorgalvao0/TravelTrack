<?php include VIEW_PATH . '/_shared/header.php'; ?>

<h3>Locais Turísticos</h3>
<div class="row">
  <?php foreach ($places as $p): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card place-card mb-3">
        <img src="public/images/place-placeholder.jpg" class="card-img-top" alt="<?php echo $p['name']; ?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo $p['name']; ?></h5>
          <p class="text-muted"><?php echo $p['city']; ?> - <?php echo $p['state']; ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="badge bg-success">Sustentabilidade: <?php echo $p['sustainability_level']; ?></span>
            </div>
            <a href="index.php?page=place&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-success">Ver Detalhes</a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
