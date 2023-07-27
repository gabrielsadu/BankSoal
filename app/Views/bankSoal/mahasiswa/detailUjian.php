<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2"><?= $ujian['nama_ujian'] ?></h1><br>
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
                        <td>Sub CPMK</td>
                        <td><?php $i = 1; foreach ($sub_cpmk as $k) {
                            echo $i . '. ' .$k.'<br>';
                            $i++;
                        }
                        ?></td>
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
            <a href="/ujian/mulai_ujian/<?= $id_kode_users; ?>" class="btn btn-primary">Mulai Ujian</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>