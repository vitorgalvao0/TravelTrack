<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Minhas Experiências Adquiridas</h3>
  <div class="points-badge">Pts <span><?php echo $user['points'] ?? 0; ?></span></div>
</div>

<?php if (empty($history)): ?>
  <div class="alert alert-info">
    <p>Você ainda não adquiriu nenhuma experiência com seus pontos.</p>
    <a href="index.php?page=places" class="btn btn-success">Explorar Locais</a>
  </div>
<?php else: ?>
  <div class="list-group">
    <?php foreach ($history as $h): ?>
      <div class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-1"><?php echo htmlspecialchars($h['place_name']); ?></h6>
          <small class="text-muted">
            <?php 
              $date = new DateTime($h['created_at']);
              echo $date->format('d/m/Y \à\s H:i');
            ?>
          </small>
        </div>
        <div class="fw-bold text-danger">-<?php echo $h['points_spent']; ?> pts</div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
