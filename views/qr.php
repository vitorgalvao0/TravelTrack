<?php include VIEW_PATH . '/_shared/header.php'; ?>

<div class="text-center">
  <h3>QR Code do Local</h3>
  <img src="public/images/qr-dummy.png" alt="QR code" class="img-fluid mb-3" style="max-width:260px">
  <p class="text-muted">Este é um QR code simulado. No app real, escaneie com a câmera.</p>
  <div>
    <input id="qrLink" class="form-control d-inline-block w-auto" value="https://example.com/checkin?place=123" readonly>
    <button class="btn btn-success ms-2" id="copyQr">Copiar link</button>
  </div>
</div>

<?php include VIEW_PATH . '/_shared/footer.php'; ?>
