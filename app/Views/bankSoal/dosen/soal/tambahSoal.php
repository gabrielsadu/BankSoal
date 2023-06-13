<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="my-3">Tambah Soal</h2>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $id; ?>">Kembali ke Daftar Soal</a>
            <br><br>
            <form action="/banksoal/<?= $id_mata_kuliah; ?>/bab/<?= $id; ?>/simpan_soal" method="post">
                <?= csrf_field(); ?>
                <script>
                    $(document).ready(function() {
                        $('.summernote').summernote({
                            callbacks: {
                                onImageUpload: function(files) {
                                    for (let i = 0; i < files.length; i++) {
                                        $.upload(files[i]);
                                    }
                                },
                                onMediaDelete: function(target) {
                                    $.delete(target[0].src);
                                }
                            },
                            tabsize: 2,
                        });
                    });
                    $.upload = function(file) {
                        let out = new FormData();
                        out.append('file', file, file.name);
                        $.ajax({
                            method: 'POST',
                            url: '<?php echo site_url('bankSoal/uploadGambar') ?>',
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: out,
                            success: function(url) {
                                let html = $('.summernote').summernote('code');
                                $('.summernote').summernote('code', html + '<img src="' + url + '"/>');
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error(textStatus + " " + errorThrown);
                            }
                        });
                    };
                    $.delete = function(src) {
                        $.ajax({
                            method: 'POST',
                            url: '<?php echo site_url('bankSoal/deleteGambar') ?>',
                            cache: false,
                            data: {
                                src: src
                            },
                            success: function(response) {
                                console.log(response);
                            }

                        });
                    };
                </script>
                <div class="row mb-3">
                    <label for="soal" class="col-sm-2 col-form-label">Soal</label>
                    <div class="col-sm-10">
                        <textarea class="summernote form-control <?= (validation_show_error('soal')) ? 'is-invalid' : ''; ?> " id="soal" name="soal"><?= old('soal'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('soal'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jawaban_a" class="col-sm-2 col-form-label">Jawaban A</label>
                    <div class="col-sm-10">
                        <textarea class="summernote form-control <?= (validation_show_error('jawaban_a')) ? 'is-invalid' : ''; ?> " id="jawaban_a" name="jawaban_a"><?= old('jawaban_a'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('jawaban_a'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jawaban_b" class="col-sm-2 col-form-label">Jawaban B</label>
                    <div class="col-sm-10">
                        <textarea class="summernote form-control <?= (validation_show_error('jawaban_b')) ? 'is-invalid' : ''; ?> " id="jawaban_b" name="jawaban_b"><?= old('jawaban_b'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('jawaban_b'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jawaban_c" class="col-sm-2 col-form-label">Jawaban C</label>
                    <div class="col-sm-10">
                        <textarea class="summernote form-control <?= (validation_show_error('jawaban_c')) ? 'is-invalid' : ''; ?> " id="jawaban_c" name="jawaban_c"><?= old('jawaban_c'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('jawaban_c'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jawaban_d" class="col-sm-2 col-form-label">Jawaban D</label>
                    <div class="col-sm-10">
                        <textarea class="summernote form-control <?= (validation_show_error('jawaban_d')) ? 'is-invalid' : ''; ?> " id="jawaban_d" name="jawaban_d"><?= old('jawaban_d'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('jawaban_d'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jawaban_benar" class="col-sm-2 col-form-label">Jawaban Benar</label>
                    <div class="col-sm-10">
                        <input type="checkbox" id="jawaban_benar" name="jawaban_benar" value="jawaban_a" style="display: inline-block; margin-right: 10px;">
                        <label for="jawaban_benar" style="display: inline-block; margin-right: 50px;"> A</label>
                        <input type="checkbox" id="jawaban_benar" name="jawaban_benar" value="jawaban_b" style="display: inline-block; margin-right: 10px;">
                        <label for="jawaban_benar" style="display: inline-block; margin-right: 50px;"> B</label>
                        <input type="checkbox" id="jawaban_benar" name="jawaban_benar" value="jawaban_c" style="display: inline-block; margin-right: 10px;">
                        <label for="jawaban_benar" style="display: inline-block; margin-right: 50px;"> C</label>
                        <input type="checkbox" id="jawaban_benar" name="jawaban_benar" value="jawaban_d" style="display: inline-block; margin-right: 10px;">
                        <label for="jawaban_benar" style="display: inline-block;"> D</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Soal</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>