<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="card mb-3 place-detail-card">
  <div class="row g-0">
    <div class="col-md-5">
      <img src="public/images/place-placeholder.jpg" class="img-fluid rounded-start" alt="<?php echo $place['name']; ?>">
    </div>
    <div class="col-md-7">
      <div class="card-body">
        <h3 class="card-title"><?php echo $place['name']; ?></h3>
        <p class="text-muted"><?php echo $place['city']; ?> - <?php echo $place['state']; ?></p>
        <p><?php echo $place['description']; ?></p>
        <div class="mb-3">
          <span class="badge bg-success">Sustentabilidade: <?php echo $place['sustainability_level']; ?></span>
          <span class="badge bg-info text-dark ms-2"><?php echo $place['points']; ?> pts por check-in</span>
        </div>
        <form method="post" action="index.php?page=checkin&action=do">
          <input type="hidden" name="place_id" value="<?php echo $place['id']; ?>">
          <button class="btn btn-success">Fazer Check-in</button>
          <a href="#reviewForm" class="btn btn-outline-secondary ms-2">Avaliar Local</a>
        </form>
      </div>
    </div>
  </div>
</div>

<h4>Avaliações</h4>
<?php if (empty($reviews)): ?>
  <p class="text-muted">Nenhuma avaliação ainda. Seja o primeiro!</p>
<?php endif; ?>
<?php foreach ($reviews as $r): ?>
  <div class="card mb-2">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div><strong><?php echo $r['user_name']; ?></strong></div>
        <div><?php echo str_repeat('★', $r['rating']); ?><?php echo str_repeat('☆', 5 - $r['rating']); ?></div>
      </div>
      <p class="mb-0 mt-2"><?php echo $r['comment']; ?></p>
    </div>
  </div>
<?php endforeach; ?>

<div id="reviewForm" class="card mt-4 p-3">
  <h5>Deixe sua avaliação</h5>
  <form method="post" action="index.php?page=review&action=create">
    <input type="hidden" name="place_id" value="<?php echo $place['id']; ?>">
    <div class="mb-3">
      <label class="form-label">Nota</label>
      <select name="rating" class="form-select" required>
        <option value="5">5 - Excelente</option>
        <option value="4">4 - Muito bom</option>
        <option value="3">3 - Bom</option>
        <option value="2">2 - Regular</option>
        <option value="1">1 - Ruim</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Comentário (opcional)</label>
      <textarea name="comment" class="form-control" rows="3"></textarea>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-success">Enviar Avaliação</button>
    </div>
  </form>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
