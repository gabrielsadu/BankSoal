<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2"><?= $mataKuliah['nama_mata_kuliah'] ?></h2>
            <a href="/banksoal" class="btn btn-primary mb-3">Kembali ke Daftar Mata Kuliah</a><br><br>
            <h2 class="mt-2">Daftar Ujian</h2><br>
            <a href="/banksoal/<?= $mataKuliah['id']; ?>/tambah_ujian" class="btn btn-primary mb-3">Tambah Ujian</a><br>
            <?php if (session()->getFlashdata('pesan_ujian')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan_ujian'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-9">Nama Ujian</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ujian as $k) : ?>
                        <?php if ($k['id_mata_kuliah'] === $mataKuliah['id']) : ?>
                            <tr>
                                <td><?= $k['nama_ujian'] ?></td>
                                <td><a href="/banksoal/<?= $mataKuliah['id']; ?>/detail_ujian/<?= $k['id']; ?>/" class="btn btn-primary">Detail</a>
                                    <a href="/banksoal/<?= $mataKuliah['id']; ?>/ubah_ujian/<?= $k['id']; ?>" class="btn btn-warning">Ubah</a>
                                    <form action="/banksoal/<?= $mataKuliah['id']; ?>/hapus_ujian/<?= $k['id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Ujian ini?');">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2 class="mt-2">Daftar Bab</h2><br>
            <a href="/banksoal/<?= $mataKuliah['id']; ?>/tambah_bab" class="btn btn-primary mb-3">Tambah Bab</a><br>
            <?php if (session()->getFlashdata('pesan_bab')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan_bab'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%">Nomor Bab</th>
                        <th scope="col" style="width: 65%">Nama Bab</th>
                        <th scope="col" style="width: 25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bab as $k) : ?>
                        <?php if ($k['id_mata_kuliah'] === $mataKuliah['id']) : ?>
                            <tr>
                                <th scope="row"><?= $k['nomor_bab'] ?></th>
                                <td><?= $k['nama_bab'] ?></td>
                                <td><a href="/banksoal/<?= $mataKuliah['id']; ?>/bab/<?= $k['id']; ?>/" class="btn btn-primary">Detail</a>
                                    <a href="/banksoal/<?= $mataKuliah['id']; ?>/ubah_bab/<?= $k['id']; ?>" class="btn btn-warning">Ubah</a>
                                    <form action="/banksoal/<?= $mataKuliah['id']; ?>/hapus_bab/<?= $k['id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Bab ini?');">Hapus</button>
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