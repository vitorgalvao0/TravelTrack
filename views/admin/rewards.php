<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Gerenciar Recompensas</h3>
  <a href="index.php?page=admin_reward_new" class="btn btn-success">Nova Recompensa</a>
</div>

<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Pontos</th><th>Ações</th></tr></thead>
  <tbody>
    <?php foreach ($rewards as $r): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['name']); ?></td>
        <td><?php echo htmlspecialchars($r['points_required']); ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="index.php?page=admin_reward_edit&id=<?php echo urlencode($r['id']); ?>">Editar</a>

          <form method="post" action="index.php?page=admin_reward_delete" style="display:inline-block;margin-left:6px;" onsubmit="return confirm('Deseja excluir esta recompensa?');">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($r['id']); ?>">
            <button class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
