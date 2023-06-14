<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2"><?= $ujian['nama_ujian'] ?></h1><br>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/">Kembali ke Halaman Sebelumnya</a><br><br>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/ubah_soal_ujian/<?= $ujian['id']; ?>" class="btn btn-primary mb-3">Ubah Soal Ujian</a><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%">Tentang Ujian</th>
                        <th scope="col" style="width: 80%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Ujian</td>
                        <td><?= $ujian['deskripsi_ujian'] ?></td>
                    </tr>
                    <tr>
                        <td>Waktu Buka Ujian</td>
                        <td><?= $ujian['waktu_buka_ujian'] ?></td>
                    </tr>
                    <tr>
                        <td>Waktu Tutup Ujian</td>
                        <td><?= $ujian['waktu_tutup_ujian'] ?></td>
                    </tr>
                    <tr>
                        <td>Durasi Ujian</td>
                        <td><?= $ujian['durasi_ujian'] ?> Menit</td>
                    </tr>
                    <tr>
                        <td> Nilai Minimum Kelulusan</td>
                        <td><?= $ujian['nilai_minimum_kelulusan'] ?> %</td>
                    </tr>
                    <?php if ($ujian['ruang_ujian']) : ?>
                        <tr>
                            <td>Ruang Ujian</td>
                            <td><?= $ujian['ruang_ujian'] ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Soal Ujian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($soal_data as $k) : ?>
                        <tr>
                            <td><?php echo $k['soal']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>