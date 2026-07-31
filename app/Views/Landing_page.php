<?php
/**
 * Landing_page.php
 *
 * File ini sekarang hanya berperan sebagai "perakit" (orchestrator) yang
 * memanggil potongan-potongan section di app/Views/landing/*.php.
 * Setiap potongan menerima variabel yang sama persis dengan yang diterima
 * file ini (identitas, struktur, artikel, galeri, videos, sejarah,
 * statPenduduk, dll) lewat get_defined_vars().
 */
$vars = get_defined_vars();
?>
<?= view('landing/head', $vars) ?>
<body>

<?= view('landing/navbar', $vars) ?>

<?= view('landing/hero', $vars) ?>

<?= view('landing/stat_strip', $vars) ?>

<?= view('landing/tentang', $vars) ?>

<?= view('landing/sejarah', $vars) ?>

<?= view('landing/layanan', $vars) ?>

<?= view('landing/struktur', $vars) ?>

<?= view('landing/berita', $vars) ?>

<?= view('landing/galeri', $vars) ?>

<?= view('landing/footer', $vars) ?>

<?= view('landing/scripts', $vars) ?>
</body>
</html>