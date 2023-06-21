<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="my-3">Hasil Ujian</h2>
            <br><br>
            <table class="table table-borderless d-flex justify-content-center">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%"></th>
                        <th scope="col" style="width: 80%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="col">
                            <h2>Nama Ujian</h2>
                        </th>
                        <th scope="col">
                            <h2>: <?= $ujian['nama_ujian'] ?></h2>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">
                            <h2>Nilai</h2>
                        </th>
                        <th scope="col">
                            <h2>: <?= $nilai ?> %</h2>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col"><br>
                            <a href="/ujian/masuk_ujian" class="btn btn-primary">Kembali</a>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><br><br>
    <div class="row">
        <div class="col-12">
            <?php
            $counter = 1;
            foreach ($soalUjian as $soal) :
                $jawaban = isset($selected_answers[$soal['id']]) ? $selected_answers[$soal['id']] : '';
            ?>
                <table class="table" style="margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th scope="col" <?php if ($soal['jawaban_benar'] === $jawaban) : ?> class="table-success" <?php else : ?> class="table-danger" <?php endif; ?>>Nomor <?= $counter ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="max-width: 800px;overflow:auto; word-wrap: break-word; white-space: pre-wrap;"><?= $soal['soal'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tbody>
                        <tr class="<?= ($jawaban == 'jawaban_a') ? 'table-secondary' : '' ?>">
                            <?php if ($soal['jawaban_benar'] == 'jawaban_a') : ?> <td style="width: 2%">&#9989;</td> <?php elseif ($jawaban == 'jawaban_a' && $jawaban != $soal['jawaban_benar']) : ?> <td style="width: 2%">&#10060;</td><?php else : ?> <td style="width: 2%"></td><?php endif; ?>
                            <td style="width: 2%">A.</td>
                            <td style="width: 96%"><?= $soal['jawaban_a'] ?></td>
                        </tr>
                        <tr class="<?= ($jawaban == 'jawaban_b') ? 'table-secondary' : '' ?>">
                            <?php if ($soal['jawaban_benar'] == 'jawaban_b') : ?> <td style="width: 2%">&#9989;</td> <?php elseif ($jawaban == 'jawaban_b' && $jawaban != $soal['jawaban_benar']) : ?> <td style="width: 2%">&#10060;</td><?php else : ?> <td style="width: 2%"></td><?php endif; ?>
                            <td style="width: 2%">B.</td>
                            <td style="width: 96%"><?= $soal['jawaban_b'] ?></td>
                        </tr>
                        <tr class="<?= ($jawaban == 'jawaban_c') ? 'table-secondary' : '' ?>">
                            <?php if ($soal['jawaban_benar'] == 'jawaban_c') : ?> <td style="width: 2%">&#9989;</td> <?php elseif ($jawaban == 'jawaban_c' && $jawaban != $soal['jawaban_benar']) : ?> <td style="width: 2%">&#10060;</td><?php else : ?> <td style="width: 2%"></td><?php endif; ?>
                            <td style="width: 2%">C.</td>
                            <td style="width: 96%"><?= $soal['jawaban_c'] ?></td>
                        </tr>
                        <tr class="<?= ($jawaban == 'jawaban_d') ? 'table-secondary' : '' ?>">
                            <?php if ($soal['jawaban_benar'] == 'jawaban_d') : ?> <td style="width: 2%">&#9989;</td> <?php elseif ($jawaban == 'jawaban_d' && $jawaban != $soal['jawaban_benar']) : ?> <td style="width: 2%">&#10060;</td><?php else : ?> <td style="width: 2%"></td><?php endif; ?>
                            <td style="width: 2%">D.</td>
                            <td style="width: 96%"><?= $soal['jawaban_d'] ?></td>
                        </tr>
                    </tbody>
                </table><br><br>
            <?php $counter++;
            endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>