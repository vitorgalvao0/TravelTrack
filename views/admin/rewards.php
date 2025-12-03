<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Gerenciar Recompensas</h3>
  <a href="#" class="btn btn-success">Nova Recompensa</a>
</div>

<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Pontos</th><th>Ações</th></tr></thead>
  <tbody>
    <?php foreach ($rewards as $r): ?>
      <tr>
        <td><?php echo $r['name']; ?></td>
        <td><?php echo $r['points_required']; ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="#">Editar</a>
          <a class="btn btn-sm btn-danger" href="#">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
