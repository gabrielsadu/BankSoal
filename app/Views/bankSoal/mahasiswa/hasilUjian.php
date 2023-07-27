<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="col-12">
        <h2 class="my-3">Hasil Ujian</h2>
        <table class="table table-borderless d-flex justify-content-center" style="background-color: #f4f6f9;">
            <thead>
                <tr>
                    <th scope="col" style="width: 20%"></th>
                    <th scope="col" style="width: 80%"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="col">
                        <h5>Nama Ujian</h5>
                    </th>
                    <th scope="col">
                        <h5>: <?= $ujian['nama_ujian'] ?></h5>
                    </th>
                </tr>
                <?php if ($ujian['tunjukkan_nilai']) : ?>
                    <tr>
                        <th scope="col">
                            <h5>Soal Benar</h5>
                        </th>
                        <th scope="col">
                            <h5>: <?= $jawabanBenar ?> dari <?= $ujian['jumlah_soal'] ?> Soal</h5>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">
                            <h5>Nilai</h5>
                        </th>
                        <th scope="col">
                            <h5>: <?= $nilai ?> %</h5>
                        </th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th scope="col">
                        <a href="/ujian" class="btn btn-primary">Kembali</a>
                    </th>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="width: 95%">Sub CPMK</th>
                    <th scope="col" style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $rowColor = null;
                foreach ($sub_cpmk as $k) {
                    if ($k[1] === $k[2]) {
                        $rowColor = 'class = "table-success"';
                    } else {
                        $rowColor = 'class = "table-danger"';
                    }

                    echo '<tr ' . $rowColor . '>
                            <td>' . $i . '. ' . $k[0] . '<br></td>
                            <td>' . $k[1] . '/' . $k[2] . '</td>
                        </tr>';
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div><br>
    <div class="col-12">
        <?php
        $counter = 1;
        foreach ($soalUjian as $soal) :
            $jawaban = null;
            foreach ($soalIdAndJawaban as $jawaban) {
                if ($jawaban['id_soal'] === $soal['id']) {
                    $jawaban = $jawaban['jawaban_dipilih'];
                    break;
                }
            }
        ?>
            <table class="table" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th scope="col" <?php if ($soal['jawaban_benar'] === $jawaban) : ?> class="table-success" <?php else : ?> class="table-danger" <?php endif; ?>>Nomor <?= $counter ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $soal['soal'] ?></td>
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
<?= $this->endSection(); ?>