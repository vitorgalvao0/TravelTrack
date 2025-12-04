<?php include VIEW_PATH . '/_shared/header.php'; ?>

<h3>Recompensas</h3>
<div class="row">
  <?php foreach ($rewards as $r): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5><?php echo $r['name']; ?></h5>
          <p class="text-muted"><?php echo $r['description']; ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="fw-bold"><?php echo $r['points_required']; ?> pts</div>
            <form method="post" action="index.php?page=reward&action=redeem">
              <input type="hidden" name="reward_id" value="<?php echo $r['id']; ?>">
              <button class="btn btn-success btn-sm">Resgatar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
