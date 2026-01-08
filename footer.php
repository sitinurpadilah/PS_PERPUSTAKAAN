<footer class="mt-5 py-4 bg-white border-top">
        <div class="container text-center">
            <p class="text-muted mb-0 small">&copy; <?php echo date('Y'); ?> <strong>PERPUSTAKAAN BIRU</strong>@snrpdl</p>
            <div class="mt-2">
                <i class="bi bi-facebook mx-2 text-biru-gelap"></i>
                <i class="bi bi-instagram mx-2 text-biru-gelap"></i>
                <i class="bi bi-twitter-x mx-2 text-biru-gelap"></i>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Inisialisasi tooltip jika diperlukan
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>
</html>