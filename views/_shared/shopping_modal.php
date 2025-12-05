<!-- Modal de Compra de Experiência -->
<div class="modal fade" id="shoppingModal<?php echo $p['id']; ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">🛍️ Comprar: <?php echo htmlspecialchars($p['name']); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Abas Horizontais -->
      <ul class="nav nav-tabs nav-fill" role="tablist" style="border-bottom: 2px solid #dee2e6; margin: 0;">
        <li class="nav-item" role="presentation" style="flex: 1;">
          <button class="nav-link active w-100 py-3" id="points-tab-<?php echo $p['id']; ?>" data-bs-toggle="tab" data-bs-target="#points-<?php echo $p['id']; ?>" type="button" role="tab">
            <i class="fas fa-coins" style="margin-right: 8px;"></i><strong>Trocar Pontos</strong>
          </button>
        </li>
        <li class="nav-item" role="presentation" style="flex: 1;">
          <button class="nav-link w-100 py-3" id="money-tab-<?php echo $p['id']; ?>" data-bs-toggle="tab" data-bs-target="#money-<?php echo $p['id']; ?>" type="button" role="tab">
            <i class="fas fa-money-bill" style="margin-right: 8px;"></i><strong>Comprar com Dinheiro</strong>
          </button>
        </li>
      </ul>

      <!-- Conteúdo das Abas -->
      <div class="tab-content">
        <!-- Aba 1: Trocar Pontos -->
        <div class="tab-pane fade show active" id="points-<?php echo $p['id']; ?>" role="tabpanel">
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="card border-success bg-light">
                  <div class="card-body">
                    <h6 class="card-title text-success"><i class="fas fa-tag"></i> Custo</h6>
                    <h4 class="text-success"><?php echo $p['points']; ?> pts</h4>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card border-primary bg-light">
                  <div class="card-body">
                    <h6 class="card-title text-primary"><i class="fas fa-wallet"></i> Seu Saldo</h6>
                    <h4 class="text-primary"><?php echo $user['points'] ?? 0; ?> pts</h4>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="mt-3">
              <?php if (($user['points'] ?? 0) >= $p['points']): ?>
                <div class="alert alert-success" role="alert">
                  <i class="fas fa-check-circle"></i> <strong>Ótimo!</strong> Você tem pontos suficientes para esta experiência.
                </div>
              <?php else: ?>
                <div class="alert alert-danger" role="alert">
                  <i class="fas fa-times-circle"></i> <strong>Pontos insuficientes!</strong> Você precisa de <strong><?php echo ($p['points'] - ($user['points'] ?? 0)); ?> pontos</strong> a mais.
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form method="post" action="index.php?page=shopping_points" style="display:inline;">
              <input type="hidden" name="place_id" value="<?php echo $p['id']; ?>">
              <button type="submit" class="btn btn-success btn-lg" <?php echo (($user['points'] ?? 0) < $p['points']) ? 'disabled' : ''; ?>>
                <i class="fas fa-check"></i> Confirmar Compra
              </button>
            </form>
          </div>
        </div>

        <!-- Aba 2: Comprar com Dinheiro -->
        <div class="tab-pane fade" id="money-<?php echo $p['id']; ?>" role="tabpanel">
          <div class="modal-body">
            <div class="alert alert-info" role="alert">
              <i class="fas fa-lightbulb"></i> <strong>Promoção!</strong> A cada real gasto, você ganha <strong>10 pontos</strong>! 🎁
            </div>
            
            <form method="post" action="index.php?page=shopping_money" id="moneyForm<?php echo $p['id']; ?>">
              <input type="hidden" name="place_id" value="<?php echo $p['id']; ?>">
              
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label"><strong><i class="fas fa-money-bill"></i> Valor a Pagar</strong></label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text">R$</span>
                    <input type="number" class="form-control" name="valor_real" id="valorReal<?php echo $p['id']; ?>" min="0.01" step="0.01" placeholder="0,00" required style="font-size: 1.5rem;">
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label"><strong><i class="fas fa-gift"></i> Pontos a Ganhar</strong></label>
                  <div class="card border-success bg-success bg-opacity-10" style="height: 100%; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body text-center">
                      <h3 class="text-success mb-0"><span id="pontosCalculados<?php echo $p['id']; ?>">0</span> <i class="fas fa-star"></i></h3>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-3 p-2 bg-light rounded">
                <small class="text-muted">
                  <i class="fas fa-info-circle"></i> <strong>Conversão:</strong> 1 real = 10 pontos | Mínimo: R$ 0,01
                </small>
              </div>
            </form>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success btn-lg" form="moneyForm<?php echo $p['id']; ?>">
              <i class="fas fa-shopping-cart"></i> Comprar Agora
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Calcula pontos em tempo real
document.getElementById('valorReal<?php echo $p['id']; ?>')?.addEventListener('input', function() {
    const valor = parseFloat(this.value) || 0;
    const pontos = Math.floor(valor * 10);
    document.getElementById('pontosCalculados<?php echo $p['id']; ?>').textContent = pontos;
});
</script>
