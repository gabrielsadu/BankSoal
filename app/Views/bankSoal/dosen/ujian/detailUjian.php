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
                        <td><?= $ujian['nama_ujian'] ?></td>
                    </tr>
                    <tr>
                        <td>Deskripsi Ujian</td>
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
                        <td>Nilai Minimum Kelulusan</td>
                        <td><?= $ujian['nilai_minimum_kelulusan'] ?> %</td>
                    </tr>
                    <tr>
                        <td>Jumlah Soal</td>
                        <td><?= $ujian['jumlah_soal'] ?></td>
                    </tr>
                    <tr>
                        <td>Acak Soal</td>
                        <td><?= ($ujian['random']) === 0 ? 'Tidak' : 'Ya'; ?></td>
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
                        <th scope="col" style="width: 85%">Bab Untuk Ujian</th>
                        <?php $count = array_count_values(array_column($soal_model, 'id_bab')); ?>
                        <?php $countAll = 0; ?>
                        <th scope="col" style="width: 15%">Total :
                            <?php foreach ($bab_data as $k) : ?>
                                <?php $countAll = $countAll + $count[$k['id']]; ?>
                            <?php endforeach; ?>
                            <?= $countAll; ?>
                            Soal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bab_data as $k) : ?>
                        <tr>
                            <td><?= $k['nama_bab']; ?></td>
                            <td>
                                <?= $count[$k['id']]; ?> Soal
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>