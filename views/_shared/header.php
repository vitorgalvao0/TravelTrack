<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>TravelTrack</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php?page=dashboard">
      <div class="logo-circle me-2"><i class="fas fa-leaf"></i></div>
      <span class="brand-text">TravelTrack</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav ms-auto" style="gap: 0.5rem;">
        <li class="nav-item"><a class="nav-link" href="index.php?page=places">Locais</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=rewards">Recompensas</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=history">Histórico</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=purchases">Experiências</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=shopping_history">Minhas Compras</a></li>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <?php 
            $user = (new UserModel())->findById($_SESSION['user_id']);
            if ($user['is_admin']):?>
            <li class="nav-item"><a class="nav-link" href="index.php?page=admin">Admin</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="index.php?page=profile">Perfil</a></li>
          <li class="nav-item"><a class="nav-link" href="#" id="logoutBtn">Sair</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="index.php?page=login">Entrar</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
<?php if (!empty($_SESSION['flash'])): ?>
  <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
    <div class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
