<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="my-3">Masuk Ujian</h2>
            <br><br>
            <form action="/ujian/mendaftar_ujian" method="post">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="kode_ujian" class="col-sm-2 col-form-label">Kode Ujian</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-lg <?= (validation_show_error('kode_ujian')) ? 'is-invalid' : ''; ?> " id="kode_ujian" name="kode_ujian" value="<?= old('kode_ujian'); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('kode_ujian'); ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Ujian</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>