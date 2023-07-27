<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2"><?= $ujian['nama_ujian'] ?></h2><br>
            <a class="btn btn-primary" href="/banksoal/<?= $id_mata_kuliah; ?>/">Kembali ke Halaman Sebelumnya</a><br><br>
            <a id="exportExcel" class="btn btn-success" href="/banksoal/export/<?= $ujian['id']; ?>/" role="button">Export Nilai ke Excel</a>
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
                    <tr>
                        <td>Tunjukkan Nilai</td>
                        <td><?= ($ujian['tunjukkan_nilai']) === 0 ? 'Tidak' : 'Ya'; ?></td>
                    </tr>
                    <tr>
                        <td>Kode Ujian</td>
                        <td>
                            <?php if ($kode_ujian) : ?>
                                <p id="codeCell"><?= $kode_ujian; ?></p>
                            <?php endif; ?>
                            <a id="generateButton" class="btn btn-primary pull-right" href="#" role="button">Generate Kode Baru</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 80%">Bab Untuk Ujian</th>
                        <?php $count = array_count_values(array_column($soal_model, 'id_bab')); ?>
                        <?php $countAll = 0; ?>
                        <th scope="col" style="width: 20%">
                            <?php foreach ($bab_data as $k) : ?>
                                <?php $countAll = $countAll + $count[$k['id']]; ?>
                            <?php endforeach; ?>
                            <?= $countAll; ?>
                            Soal Tersedia
                        </th>
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
<script>
    var generateButton = document.getElementById('generateButton');

    if (generateButton) {
        generateButton.addEventListener('click', function() {
            var randomCode = generateRandomCode();
            document.getElementById('codeCell').textContent = randomCode;
            // Send an AJAX request to save the code
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Code successfully saved
                    console.log('Code saved:', randomCode);
                }
            };
            xhttp.open('POST', '/banksoal/save-code', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('kode_ujian=' + encodeURIComponent(randomCode) + '&id_ujian=' + encodeURIComponent(<?php echo $ujian['id']; ?>));
        });
    }

    document.getElementById('exportExcel').addEventListener('click', function() {
        // Send an AJAX request to save the code
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log('Excel exported');
            }
        };
        xhttp.open('POST', '/ujian/export/<?= $ujian['id']; ?>', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    });

    function generateRandomCode() {
        var charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var code = '';
        for (var i = 0; i < 8; i++) {
            var randomIndex = Math.floor(Math.random() * charset.length);
            code += charset[randomIndex];
        }
        return code;
    }
</script>
<?= $this->endSection(); ?>