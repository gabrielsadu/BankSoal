<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">BAB <?= $bab['nomor_bab'] ?> - <?= $bab['nama_bab'] ?></h1><br>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $id_bab; ?>">Kembali ke Daftar Soal</a>
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
                        <th scope="col">Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_a') ? 'table-success' : '' ?>">
                        <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;">A.<?= $soal['jawaban_a'] ?></td>
                    </tr>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_bb') ? 'table-success' : '' ?>">
                        <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;">B.<?= $soal['jawaban_b'] ?></td>
                    </tr>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_c') ? 'table-success' : '' ?>">
                        <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;">C.<?= $soal['jawaban_c'] ?></td>
                    </tr>
                    <tr class="<?= ($soal['jawaban_benar'] == 'jawaban_d') ? 'table-success' : '' ?>">
                        <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;">D.<?= $soal['jawaban_d'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>