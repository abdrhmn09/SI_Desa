<!-- ═══════════════════════════ STAT STRIP ═══════════════════════════ -->
<section class="stat-strip d-none d-md-block">
    <div class="container">
        <div class="row g-4 justify-content-center text-center">
            <div class="col-md-3">
                <div class="stat-box">
                    <i class="bi bi-people-fill" style="background:#e6f4ed; color:var(--green-mid)"></i>
                    <div>
                        <div class="num"><?= number_format($statPenduduk ?? 0) ?></div>
                        <div class="lbl text-uppercase">Total Penduduk</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <i class="bi bi-journal-bookmark-fill" style="background:#eff6ff; color:#3b82f6"></i>
                    <div>
                        <div class="num"><?= number_format($statKK ?? 0) ?></div>
                        <div class="lbl text-uppercase">Kartu Keluarga</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <i class="bi bi-newspaper" style="background:#fef9ec; color:var(--gold)"></i>
                    <div>
                        <div class="num"><?= number_format($statArtikel ?? 0) ?></div>
                        <div class="lbl text-uppercase">Berita Diterbitkan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>