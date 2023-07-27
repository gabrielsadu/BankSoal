<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Bank Soal</h2>
            </br></br>
            <div class="col d-flex justify-content-center">
                <?php foreach ($mataKuliah as $k) : ?>
                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $k['nama_mata_kuliah'] ?></h5>
                            <p class="card-text"><?= $k['kode_mata_kuliah'] ?></p>
                            <a href="/banksoal/<?= $k['id']; ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>