<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Ujian <?= $ujian['nama_ujian'] ?></h1><br>
            <?php foreach ($soal as $k) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Soal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;"><?= $k['soal'] ?></td>
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
                        <tr class="<?= ($k['jawaban_benar'] == 'jawaban_a') ? 'table-success' : '' ?>">
                            <td>A.</td>
                            <td><?= $k['jawaban_a'] ?></td>
                        </tr>
                        <tr class="<?= ($k['jawaban_benar'] == 'jawaban_b') ? 'table-success' : '' ?>">
                            <td>B.</td>
                            <td><?= $k['jawaban_b'] ?></td>
                        </tr>
                        <tr class="<?= ($k['jawaban_benar'] == 'jawaban_c') ? 'table-success' : '' ?>">
                            <td>C.</td>
                            <td><?= $k['jawaban_c'] ?></td>
                        </tr>
                        <tr class="<?= ($k['jawaban_benar'] == 'jawaban_d') ? 'table-success' : '' ?>">
                            <td>D.</td>
                            <td><?= $k['jawaban_d'] ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endforeach; ?>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>