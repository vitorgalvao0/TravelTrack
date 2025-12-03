<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Gerenciar Locais</h3>
  <a href="#" class="btn btn-success">Novo Local</a>
</div>

<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Cidade</th><th>Sustent.</th><th>Pontos</th><th>Ações</th></tr></thead>
  <tbody>
    <?php foreach ($places as $p): ?>
      <tr>
        <td><?php echo $p['name']; ?></td>
        <td><?php echo $p['city']; ?></td>
        <td><?php echo $p['sustainability_level']; ?></td>
        <td><?php echo $p['points']; ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="#">Editar</a>
          <a class="btn btn-sm btn-danger" href="#">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
