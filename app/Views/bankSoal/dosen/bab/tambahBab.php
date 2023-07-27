<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Tambah Bab</h2>
            <a class="btn btn-primary" href="/banksoal/<?= $id; ?>">Kembali ke Daftar Bab</a>
            <br><br>
            <form action="/banksoal/<?= $id; ?>/simpan_bab" method="post">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="nomor_bab" class="col-sm-2 col-form-label">Nomor Bab</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control <?= (validation_show_error('nomor_bab')) ? 'is-invalid' : ''; ?> " id="nomor_bab" name="nomor_bab" value="<?= old('nomor_bab'); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('nomor_bab'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nama_bab" class="col-sm-2 col-form-label">Nama Bab</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (validation_show_error('nama_bab')) ? 'is-invalid' : ''; ?> " id="nama_bab" name="nama_bab" value="<?= old('nama_bab'); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('nama_bab'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sub_cpmk" class="col-sm-2 col-form-label">Sub CPMK</label>
                    <div class="col-sm-10">
                        <textarea class="form-control <?= (validation_show_error('sub_cpmk')) ? 'is-invalid' : ''; ?> " id="sub_cpmk" name="sub_cpmk" value="<?= old('sub_cpmk'); ?>"></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('sub_cpmk'); ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Bab</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>