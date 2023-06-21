<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="my-3">Ubah Ujian</h2>
            <a href="/banksoal/<?= $id; ?>">Kembali ke Daftar Bab</a>
            <br><br>
            <form action="/banksoal/<?= $id; ?>/update_ujian/<?= $ujian['id']; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="nama_ujian" class="col-sm-2 col-form-label">Nama Ujian</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (validation_show_error('nama_ujian')) ? 'is-invalid' : ''; ?> " id="nama_ujian" name="nama_ujian" value="<?= $ujian['nama_ujian']; ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('nama_ujian'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi_ujian" class="col-sm-2 col-form-label">Deskripsi Ujian</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (validation_show_error('deskripsi_ujian')) ? 'is-invalid' : ''; ?> " id="deskripsi_ujian" name="deskripsi_ujian" value="<?= $ujian['deskripsi_ujian']; ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('deskripsi_ujian'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="waktu_buka_ujian" class="col-sm-2 col-form-label">Waktu Buka Ujian</label>
                    <div class="col-auto">
                        <input type="datetime-local" class="form-control <?= (validation_show_error('waktu_buka_ujian')) ? 'is-invalid' : ''; ?>" id="waktu_buka_ujian" name="waktu_buka_ujian" value="<?= $ujian['waktu_buka_ujian']; ?>" required step="any">
                        <div class="invalid-feedback">
                            <?= validation_show_error('waktu_buka_ujian'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="waktu_tutup_ujian" class="col-sm-2 col-form-label">Waktu tutup Ujian</label>
                    <div class="col-auto">
                        <input type="datetime-local" class="form-control <?= (validation_show_error('waktu_tutup_ujian')) ? 'is-invalid' : ''; ?>" id="waktu_tutup_ujian" name="waktu_tutup_ujian" value="<?= $ujian['waktu_tutup_ujian']; ?>" required step="any">
                        <div class="invalid-feedback">
                            <?= validation_show_error('waktu_tutup_ujian'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="durasi_ujian" class="col-sm-2 col-form-label">Durasi Ujian</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control <?= (validation_show_error('durasi_ujian')) ? 'is-invalid' : ''; ?>" id="durasi_ujian" name="durasi_ujian" value="<?= $ujian['durasi_ujian']; ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('durasi_ujian'); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <span id="menit" class="form-text">
                            Menit
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nilai_minimum_kelulusan" class="col-sm-2 col-form-label">Nilai Minimum Kelulusan</label>
                    <div class="col-sm-2 mt-4">
                        <input type="number" class="form-control <?= (validation_show_error('nilai_minimum_kelulusan')) ? 'is-invalid' : ''; ?>" id="nilai_minimum_kelulusan" name="nilai_minimum_kelulusan" value="<?= $ujian['nilai_minimum_kelulusan']; ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('nilai_minimum_kelulusan'); ?>
                        </div>
                    </div>
                    <div class="col-auto mt-4">
                        <span id="menit" class="form-text">%</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jumlah_soal" class="col-sm-2 col-form-label">Jumlah Soal Untuk Ujian</label>
                    <div class="col-sm-2 mt-4">
                        <input type="number" class="form-control <?= (validation_show_error('jumlah_soal')) ? 'is-invalid' : ''; ?>" id="jumlah_soal" name="jumlah_soal" value="<?= $ujian['jumlah_soal']; ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('jumlah_soal'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="pilih_soal_dari_bab" class="col-sm-2 col-form-label">Pilih Soal Dari Bab</label>
                    <div class="col">
                        <ul class="list-group list-group-flush" id="pilih_soal_dari_bab">
                            <?php foreach ($bab as $bab) : ?>
                                <?php if ($bab['id_mata_kuliah'] == $id) : ?>
                                    <?php
                                    $checked = '';
                                    foreach ($bab_untuk_ujian as $row) {
                                        if ($row == $bab['id']) {
                                            $checked = 'checked';
                                            break;
                                        }
                                    }
                                    ?>
                                    <li class="list-group-item">
                                        <input class="form-check-input me-1" type="checkbox" value="<?= $bab['id'] ?>" name="bab[]" <?= $checked ?>>
                                        <label class="form-check-label" for="checkbox_bab_<?= $bab['id'] ?>"><?= $bab['nama_bab'] ?></label>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="random" class="col-sm-2 col-form-label">Acak Soal</label>
                    <div class="col-sm-2 mt-4">
                        <input class="form-check-input col-sm-3" type="checkbox" id="random" name="random" <?= $ujian['random'] == 0 ? '' : 'checked' ?>>
                        <br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="menggunakan_ruang_ujian" class="col-sm-2 col-form-label">Menggunakan Ruang Ujian</label>
                    <div class="col-sm-2 mt-4">
                        <input class="form-check-input col-sm-3" type="checkbox" id="menggunakan_ruang_ujian" name="menggunakan_ruang_ujian" <?= null != ($ujian['ruang_ujian']) ? 'checked' : '' ?>>
                        <br>
                    </div>
                </div>

                <div id="menudiv" style="display:none;" class="row mb-3">
                    <div class="col-sm-2"> <label for="ruang_ujian" class="col-form-label">Pilih Ruang</label> </div>
                    <div class="col-sm-10"> <select id="ruang_ujian" name="ruang_ujian" class="form-control">
                            <option value="">Pilih Ruang :</option>
                            <option value="ruang1" <?= $ujian['ruang_ujian'] === 'ruang1' ? 'selected' : '' ?>>Ruang 1</option>
                            <option value="ruang2" <?= $ujian['ruang_ujian'] === 'ruang2' ? 'selected' : '' ?>>Ruang 2</option>
                            <option value="ruang3" <?= $ujian['ruang_ujian'] === 'ruang3' ? 'selected' : '' ?>>Ruang 3</option>

                        </select> </div>
                </div>
                <br>
                <script>
                    var checkbox = document.getElementById("menggunakan_ruang_ujian");
                    var menudiv = document.getElementById("menudiv");

                    function setDisplay() {
                        menudiv.style.display = checkbox.checked ? "flex" : "none";
                    }
                    setDisplay();
                    checkbox.addEventListener("change", setDisplay);
                </script>
                <button type="submit" class="btn btn-primary">Ubah Ujian</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>