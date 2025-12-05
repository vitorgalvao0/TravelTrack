<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="card mb-3 place-detail-card">
  <div class="row g-0">
    <div class="col-md-5">
      <?php $img = !empty($place['imagem']) ? 'upload/' . $place['imagem'] : 'public/images/place-placeholder.jpg'; ?>
      <img src="<?= $img ?>" class="img-fluid rounded-start" alt="<?php echo $place['name']; ?>">
    </div>
    <div class="col-md-7">
      <div class="card-body">
        <h3 class="card-title"><?php echo $place['name']; ?></h3>
        <p class="text-muted"><?php echo $place['city']; ?> - <?php echo $place['state']; ?></p>
        <p><?php echo $place['description']; ?></p>
        <div class="mb-3">
          <span class="badge bg-success">Sustentabilidade: <?php echo $place['sustentabilidade']; ?></span>
          <span class="badge bg-info text-dark ms-2"><?php echo $place['points']; ?> pts por check-in</span>
        </div>
        <form method="post" action="index.php?page=checkin&action=do">
          <input type="hidden" name="place_id" value="<?php echo $place['id']; ?>">
          <button class="btn btn-success">Fazer Check-in</button>
          <a href="#reviewForm" class="btn btn-outline-secondary ms-2">Avaliar Local</a>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#shoppingModal<?php echo $place['id']; ?>">
              Comprar
            </button>
          <?php else: ?>
            <a href="index.php?page=login" class="btn btn-primary ms-2">Comprar</a>
          <?php endif; ?>
        </form>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <!-- Carrega o modal com a variável $place renomeada temporariamente para $p -->
          <?php $p = $place; include VIEW_PATH . '/_shared/shopping_modal.php'; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

      <!-- Minimap base: container e dados para uso pelo JS -->
      <div id="miniMapWrapper" class="mb-3">
        <h5>Localização</h5>
        <div id="miniMap" class="minimap" style="width:100%;height:220px;border:1px solid #ddd;border-radius:4px;background:#f6f6f6;display:flex;align-items:center;justify-content:center;">
          <span class="text-muted">Minimapa carregando...</span>
        </div>
        <?php
          $dest_parts = [];
          $dest_parts[] = $place['name'] ?? '';
          $dest_parts[] = $place['logradouro'] ?? '';
          if (!empty($place['numero_casa'])) $dest_parts[] = $place['numero_casa'];
          $dest_parts[] = $place['city'] ?? '';
          $dest_parts[] = $place['state'] ?? '';
          $destination_address = trim(implode(', ', array_filter($dest_parts, function($v){ return trim((string)$v) !== ''; }))); 

          $user_origin = 'Senac Hub Academy, Campo Grande, MS';
          if (!empty($user) && is_array($user)) {
            $orig_parts = [];
            $orig_parts[] = $user['logradouro'] ?? '';
            if (!empty($user['numero_casa'])) $orig_parts[] = $user['numero_casa'];
            $orig_parts[] = $user['city'] ?? '';
            $orig_parts[] = $user['state'] ?? '';
            $tmp = trim(implode(', ', array_filter($orig_parts, function($v){ return trim((string)$v) !== ''; })));
            if ($tmp !== '') $user_origin = $tmp;
          }
        ?>
        <div id="miniMapData" style="display:none;"
             data-lat="<?php echo htmlspecialchars($place['latitude'] ?? $place['lat'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
             data-lng="<?php echo htmlspecialchars($place['longitude'] ?? $place['lng'] ?? $place['lon'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
             data-destination-address="<?php echo htmlspecialchars($destination_address, ENT_QUOTES, 'UTF-8'); ?>"
             data-origin-address="<?php echo htmlspecialchars($user_origin, ENT_QUOTES, 'UTF-8'); ?>">
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
