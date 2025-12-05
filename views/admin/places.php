<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Gerenciar Locais</h3>
  <a href="index.php?page=admin_place_new" class="btn btn-success">Novo Local</a>
</div>

<table class="table table-striped">
  <thead><tr><th>Nome</th><th>Cidade</th><th>Sustent.</th><th>Pontos</th><th>Ações</th></tr></thead>
  <tbody>
    <?php foreach ($places as $p): ?>
      <tr>
        <td>
          <?php if (!empty($p['imagem'])): ?>
              <img src="upload/<?php echo htmlspecialchars($p['imagem']); ?>" style="height:40px;width:auto;border-radius:6px;margin-right:8px;vertical-align:middle;">
            <?php endif; ?>
          <?php echo htmlspecialchars($p['name']); ?>
        </td>
        <td><?php echo htmlspecialchars($p['city']); ?></td>
        <td><?php echo htmlspecialchars($p['sustentabilidade']); ?></td>
        <td><?php echo htmlspecialchars($p['points']); ?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="index.php?page=admin_place_edit&id=<?php echo urlencode($p['id']); ?>">Editar</a>
          <a class="btn btn-sm btn-warning ms-1" href="index.php?page=upload_image_form&place_id=<?php echo urlencode($p['id']); ?>">Upload Imagem</a>

          <form method="post" action="index.php?page=admin_place_delete" style="display:inline-block;margin-left:6px;" onsubmit="return confirm('Deseja excluir este local?');">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($p['id']); ?>">
            <button class="btn btn-sm btn-danger">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
