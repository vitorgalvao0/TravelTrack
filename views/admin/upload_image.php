<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="container mt-5" style="max-width:600px;">
  <h3 class="mb-4">Upload de imagem</h3>
  <form action="index.php?page=upload_image" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="place_id" value="<?= htmlspecialchars($_GET['place_id'] ?? '') ?>">
    <div class="mb-3">
      <label class="form-label">Escolha a imagem</label>
      <input type="file" name="imagem" class="form-control" accept="image/*" required>
    </div>
    <div class="d-flex justify-content-between">
      <a href="index.php?page=admin_places" class="btn btn-secondary">Voltar</a>
      <button class="btn btn-success">Enviar</button>
    </div>
  </form>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>