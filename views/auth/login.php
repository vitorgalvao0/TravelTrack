<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="auth-card mx-auto mt-5">
  <h3>Entrar</h3>
  <?php if (!empty($_SESSION['flash'])): ?><div class="alert alert-warning"><?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?></div><?php endif; ?>
  <form method="post" action="index.php?page=auth&action=login">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <a href="index.php?page=register">Criar Conta</a>
      <button class="btn btn-success">Entrar</button>
    </div>
  </form>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
