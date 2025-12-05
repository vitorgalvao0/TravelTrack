<?php include VIEW_PATH . '/_shared/header.php'; ?>

<?php
// $reward pode ser null (novo) ou array (edição)
// $action === 'create' | 'update'
$editing = !empty($reward);
$formAction = $action === 'update' ? 'index.php?page=admin_reward_update' : 'index.php?page=admin_reward_create';
?>

<div class="card mx-auto mt-4" style="max-width:720px;">
  <div class="card-body">
    <h4><?php echo $editing ? 'Editar Recompensa' : 'Nova Recompensa'; ?></h4>
    <form method="post" action="<?php echo $formAction; ?>">
      <?php if ($editing): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($reward['id']); ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($reward['name'] ?? ''); ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($reward['description'] ?? ''); ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Pontos necessários</label>
        <input type="number" name="points_required" class="form-control" required value="<?php echo htmlspecialchars($reward['points_required'] ?? 0); ?>">
      </div>

      <div class="d-flex justify-content-end">
        <a class="btn btn-secondary me-2" href="index.php?page=admin_rewards">Cancelar</a>
        <button class="btn btn-success"><?php echo $editing ? 'Salvar alterações' : 'Criar recompensa'; ?></button>
      </div>
    </form>
  </div>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
