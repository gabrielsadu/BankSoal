<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">BAB <?= $bab['nomor_bab'] ?> - <?= $bab['nama_bab'] ?></h2><br>
            <a class="btn btn-primary" href="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $id_bab; ?>">Kembali ke Daftar Soal</a>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Soal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;"><?= $soal['soal'] ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%">Opsi</th>
                        <th scope="col" style="width: 95%">Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_a') ? 'table-success' : '' ?>">
                        <td>A.</td>
                        <td><?= $soal['jawaban_a'] ?></td>
                    </tr>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_b') ? 'table-success' : '' ?>">
                        <td>B.</td>
                        <td><?= $soal['jawaban_b'] ?></td>
                    </tr>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_c') ? 'table-success' : '' ?>">
                        <td>C.</td>
                        <td><?= $soal['jawaban_c'] ?></td>
                    </tr>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_d') ? 'table-success' : '' ?>">
                        <td>D.</td>
                        <td><?= $soal['jawaban_d'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>