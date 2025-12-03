<?php include VIEW_PATH . '/_shared/header.php'; ?>

<h3>Histórico de Check-ins</h3>
<?php if (empty($history)): ?>
  <p class="text-muted">Nenhum check-in registrado.</p>
<?php endif; ?>
<div class="list-group">
  <?php foreach ($history as $h): ?>
    <div class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <strong><?php echo $h['place_name']; ?></strong>
        <div class="text-muted small"><?php echo $h['created_at']; ?></div>
      </div>
      <div class="fw-bold">+<?php echo $h['points']; ?> pts</div>
    </div>
  <?php endforeach; ?>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
