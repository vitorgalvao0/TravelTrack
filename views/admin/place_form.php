<?php include VIEW_PATH . '/_shared/header.php'; ?>

<?php
// $place pode ser null (novo) ou array (edição)
// $action === 'create' | 'update'
$editing = !empty($place);
$formAction = $action === 'update' ? 'index.php?page=admin_place_update' : 'index.php?page=admin_place_create';
?>

<div class="card mx-auto mt-4" style="max-width:800px;">
  <div class="card-body">
    <h4><?php echo $editing ? 'Editar Local' : 'Novo Local'; ?></h4>
    <form method="post" action="<?php echo $formAction; ?>" enctype="multipart/form-data">
      <?php if ($editing): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($place['id']); ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($place['name'] ?? ''); ?>">
      </div>

      <div class="row g-2">
        <div class="col-md-6 mb-3">
          <label class="form-label">Logradouro</label>
          <input type="text" name="logradouro" class="form-control" value="<?php echo htmlspecialchars($place['logradouro'] ?? ''); ?>">
        </div>
        <div class="col-md-2 mb-3">
          <label class="form-label">Número</label>
          <input type="text" name="numero_casa" class="form-control" value="<?php echo htmlspecialchars($place['numero_casa'] ?? ''); ?>">
        </div>
        <div class="col-md-2 mb-3">
          <label class="form-label">CEP</label>
          <input type="text" name="cep" class="form-control" value="<?php echo htmlspecialchars($place['cep'] ?? ''); ?>">
        </div>
        <div class="col-md-2 mb-3">
          <label class="form-label">UF</label>
          <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($place['state'] ?? ''); ?>">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Cidade</label>
        <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($place['city'] ?? ''); ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($place['description'] ?? ''); ?></textarea>
      </div>

      <div class="row g-2">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tipo</label>
          <input type="text" name="tipo" class="form-control" value="<?php echo htmlspecialchars($place['tipo'] ?? 'turistico'); ?>">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Pontos base (p/ check-in)</label>
          <input type="number" name="pontos_base" class="form-control" value="<?php echo htmlspecialchars($place['points'] ?? ($place['pontos_base'] ?? 0)); ?>">
        </div>
      </div>

      <div class="row g-2">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nível de Sustentabilidade</label>
          <select name="sustentabilidade" class="form-select">
            <?php $cur = $place['sustentabilidade'] ?? 3; for ($i=1;$i<=5;$i++): ?>
              <option value="<?= $i ?>" <?= $i == $cur ? 'selected' : '' ?>><?= $i ?><?= $i==1? ' (baixo)':($i==5? ' (alto)':'') ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Imagem (opcional)</label>
          <input type="file" name="imagem" class="form-control" accept="image/*">
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <a class="btn btn-secondary me-2" href="index.php?page=admin_places">Cancelar</a>
        <button class="btn btn-success"><?php echo $editing ? 'Salvar alterações' : 'Criar local'; ?></button>
      </div>
    </form>
  </div>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
