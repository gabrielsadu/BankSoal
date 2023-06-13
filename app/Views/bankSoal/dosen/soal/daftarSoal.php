<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">BAB <?= $bab['nomor_bab'] ?> - <?= $bab['nama_bab'] ?></h1><br>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/">Kembali ke Daftar Bab</a><br><br>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $bab['id'] ?>/tambah_soal" class="btn btn-primary mb-3">Tambah Soal</a><br>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 75%">Soal</th>
                        <th scope="col" style="width: 25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($soal as $k) : ?>
                        <?php if ($k['id_bab'] === $bab['id']) : ?>
                            <tr>
                                <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;"><?= $k['soal'] ?></td>
                                <td><a href="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $bab['id'] ?>/detail_soal/<?= $k['id'] ?>" class="btn btn-primary">Detail</a>
                                    <a href="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $bab['id'] ?>/ubah_soal/<?= $k['id'] ?>" class="btn btn-warning">Ubah</a>
                                    <form action="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $bab['id'] ?>/hapus_soal/<?= $k['id'] ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Soal ini?');">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>