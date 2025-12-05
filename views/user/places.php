<?php include VIEW_PATH . '/_shared/header.php'; ?>

<h3>Locais Turísticos</h3>
<div class="row g-4">
  <?php foreach ($places as $p): ?>
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card place-card h-100">
          <?php $img = !empty($p['imagem']) ? 'upload/' . $p['imagem'] : 'public/images/place-placeholder.jpg'; ?>
          <img src="<?= $img ?>" class="card-img-top" alt="<?php echo $p['name']; ?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo $p['name']; ?></h5>
          <p class="text-muted"><?php echo $p['city']; ?> - <?php echo $p['state']; ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="badge bg-success">Sustentabilidade: <?php echo $p['sustentabilidade']; ?></span>
              <span class="badge bg-info text-dark ms-1"><?php echo $p['points']; ?> pts</span>
            </div>
            <div class="d-flex gap-2">
              <a href="index.php?page=place&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-success">Ver Detalhes</a>
              <?php if (!empty($_SESSION['user_id'])): ?>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#shoppingModal<?php echo $p['id']; ?>">
                  Comprar
                </button>
              <?php else: ?>
                <a href="index.php?page=login" class="btn btn-sm btn-primary">Comprar</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <?php include VIEW_PATH . '/_shared/shopping_modal.php'; ?>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
