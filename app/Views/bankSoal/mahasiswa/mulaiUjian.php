<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <h1 class="mt-2"><?= $ujian['nama_ujian'] ?></h1><br>
    <h2 class="mt-2">Sisa Waktu: <span id="countdown"></span></h2><br>
    <form action="/ujian/hasil_ujian/<?= $id ?>" method="post" id="ujianForm">
        <?= csrf_field() ?>
        <?php foreach ($soal as $k) :
            $jawaban_dipilih = null;
            foreach ($jawaban as $jawaban) {
                if ($jawaban['id_soal'] === $k['id']) {
                    $jawaban_dipilih = $jawaban['jawaban_dipilih'];
                    break;
                }
            }
        ?>
            <div class="row">
                <div class="col-1">
                    <div style="display: flex; justify-content: center;">
                        <h1><?= $currentPage; ?></h1>
                    </div>
                </div>
                <div class="col-8">
                    <?= $k['soal'] ?><br>
                    <div class="btn-group-vertical btn-group-toggle" data-toggle="buttons">
                        <div>
                            <label class="btn btn-outline-primary <?php if ($jawaban_dipilih === 'jawaban_a') echo 'active'; ?>">
                                <input type="radio" class="btn-check" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_a" <?php if ($jawaban_dipilih === 'jawaban_a') echo 'checked'; ?>> A
                            </label>
                            <label class="form-check-label ml-2" for="checkbox_bab_<?= $k['id'] ?>"><?= $k['jawaban_a'] ?></label>
                        </div>
                        <div>
                            <label class="btn btn-outline-primary <?php if ($jawaban_dipilih === 'jawaban_b') echo 'active'; ?>">
                                <input type="radio" class="btn-check" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_b" <?php if ($jawaban_dipilih === 'jawaban_b') echo 'checked'; ?>> B
                            </label>
                            <label class="form-check-label ml-2" for="checkbox_bab_<?= $k['id'] ?>"><?= $k['jawaban_b'] ?></label>
                        </div>
                        <div>
                            <label class="btn btn-outline-primary <?php if ($jawaban_dipilih === 'jawaban_c') echo 'active'; ?>">
                                <input type="radio" class="btn-check" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_c" <?php if ($jawaban_dipilih === 'jawaban_c') echo 'checked'; ?>> C
                            </label>
                            <label class="form-check-label ml-2" for="checkbox_bab_<?= $k['id'] ?>"><?= $k['jawaban_c'] ?></label>
                        </div>
                        <div>
                            <label class="btn btn-outline-primary <?php if ($jawaban_dipilih === 'jawaban_d') echo 'active'; ?>">
                                <input type="radio" class="btn-check" name="jawaban[<?= $k['id'] ?>][]" value="jawaban_d" <?php if ($jawaban_dipilih === 'jawaban_d') echo 'checked'; ?>> D
                            </label>
                            <label class="form-check-label ml-2" for="checkbox_bab_<?= $k['id'] ?>"><?= $k['jawaban_d'] ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="col">
                    <?= $pager->links('soal', 'ujian_pagination'); ?>
                    <input type="hidden" name="timer" id="timerInput">
                </div>
            </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('input[name="jawaban[' + <?= $k['id'] ?> + '][]"]').click(function(event) {
            event.preventDefault(); // Prevent the default form submission
            var idKodeUsers = <?= $id ?>;
            var idSoal = <?= $k['id'] ?>;
            var jawabanDipilih = this.value;
            $.ajax({
                url: '/ujian/simpan_jawaban_dipilih',
                type: 'POST',
                data: {
                    id_kode_users: idKodeUsers,
                    id_soal: idSoal,
                    jawaban_dipilih: jawabanDipilih
                },
                success: function(response) {
                    console.log('Answer submitted successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error submitting answer:', error);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>