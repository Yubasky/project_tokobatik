<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-title">
    <div>
        <h4><i class="bi bi-box-seam me-2 text-primary"></i><?= esc($title) ?></h4>
        <div class="title-meta">Total: <?= count($produk) ?> produk</div>
    </div>
    <?php if ($role === 'admin'): ?>
    <a href="<?= base_url('admin/produk/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Produk
    </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <?php if ($role === 'admin'): ?>
                        <th style="width:150px">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produk)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                            Belum ada data produk
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($produk as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php if ($p['gambar']): ?>
                            <img src="<?= base_url('uploads/produk/' . $p['gambar']) ?>"
                                 class="img-preview" alt="<?= esc($p['nama_produk']) ?>">
                            <?php else: ?>
                            <div class="avatar-sm bg-dark-card border-dark-theme" style="width:50px;height:50px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-image text-muted fs-4"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-semibold"><?= esc($p['nama_produk']) ?></div>
                            <small class="text-muted"><?= esc(substr($p['deskripsi'] ?? '', 0, 50)) ?><?= strlen($p['deskripsi'] ?? '') > 50 ? '...' : '' ?></small>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-25 text-primary">
                                <?= esc($p['kategori'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge <?= $p['stok'] <= 5 ? 'stok-badge-low' : 'stok-badge-ok' ?>">
                                <?= $p['stok'] <= 5 ? '<i class="bi bi-exclamation-triangle me-1"></i>' : '' ?>
                                <?= $p['stok'] ?> pcs
                            </span>
                        </td>
                        <?php if ($role === 'admin'): ?>
                        <td>
                            <a href="<?= base_url('admin/produk/edit/' . $p['id_produk']) ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= base_url('admin/produk/delete/' . $p['id_produk']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus produk ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
