</div> <!-- penutup container -->

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
  // Auto dismiss alert setelah 4 detik
  const alertEl = document.querySelector('.alert-dismissible');
  if (alertEl) {
    setTimeout(() => alertEl.classList.remove('show'), 4000);
  }
</script>

<footer class="bg-dark text-white text-center py-3 mt-5 shadow-sm">
  <div class="container">
    <small>&copy; <?= date('Y') ?> UASEcommerce — All rights reserved.</small>
  </div>
</footer>
</body>
</html>
