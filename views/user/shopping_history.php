<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Histórico de Minhas Compras</h3>
  <div class="points-badge">Pts <span><?php echo $user['points'] ?? 0; ?></span></div>
</div>

<!-- Estatísticas -->
<?php if ($stats): ?>
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h6 class="text-muted">Total de Compras</h6>
          <h3 class="text-primary"><?php echo $stats['total_compras'] ?? 0; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h6 class="text-muted">Compras com Pontos</h6>
          <h3 class="text-warning"><?php echo $stats['compras_pontos'] ?? 0; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h6 class="text-muted">Compras com Dinheiro</h6>
          <h3 class="text-success"><?php echo $stats['compras_dinheiro'] ?? 0; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h6 class="text-muted">Pontos Ganhos</h6>
          <h3 class="text-success">+<?php echo $stats['total_pontos_recebidos'] ?? 0; ?></h3>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Histórico -->
<?php if (empty($history)): ?>
  <div class="alert alert-info">
    <p>Você ainda não fez nenhuma compra.</p>
    <a href="index.php?page=places" class="btn btn-primary">Explorar Locais</a>
  </div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>Data</th>
          <th>Local</th>
          <th>Tipo de Compra</th>
          <th>Valor</th>
          <th>Pontos</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($history as $h): ?>
          <tr>
            <td>
              <?php 
                $date = new DateTime($h['data_compra']);
                echo $date->format('d/m/Y H:i');
              ?>
            </td>
            <td><strong><?php echo htmlspecialchars($h['place_name']); ?></strong></td>
            <td>
              <?php if ($h['tipo_compra'] === 'dinheiro'): ?>
                <span class="badge bg-success"><i class="fas fa-money-bill"></i> Dinheiro</span>
              <?php else: ?>
                <span class="badge bg-warning text-dark"><i class="fas fa-coins"></i> Pontos</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($h['tipo_compra'] === 'dinheiro'): ?>
                <strong>R$ <?php echo number_format($h['valor_real'], 2, ',', '.'); ?></strong>
              <?php else: ?>
                <strong class="text-danger">-<?php echo $h['valor_gasto']; ?> pts</strong>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($h['pontos_recebidos'] > 0): ?>
                <span class="badge bg-success">+<?php echo $h['pontos_recebidos']; ?> pts</span>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
