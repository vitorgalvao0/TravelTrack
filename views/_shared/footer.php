</main>
<footer class="mt-5 py-4 text-center text-muted">
  <div class="container">TravelTrack © <?php echo date('Y'); ?> - Eco gamification for tourists</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/app.js"></script>
<?php
    $gm_key = getenv('GOOGLE_MAPS_API_KEY') ?: (defined('GOOGLE_MAPS_API_KEY') ? GOOGLE_MAPS_API_KEY : '');
  if (!empty($place)):
?>
<script>
  window.GOOGLE_MAPS_API_KEY = '<?php echo htmlspecialchars($gm_key, ENT_QUOTES, 'UTF-8'); ?>';
</script>
<script src="public/js/place.js"></script>
<?php endif; ?>
</body>
</html>
