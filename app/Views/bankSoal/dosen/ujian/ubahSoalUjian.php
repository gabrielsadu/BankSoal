<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    .bab-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .bab-title {
        flex-grow: 1;
        margin-right: 10px;
    }

    .soal-list {
        display: none;
        margin-top: 10px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Soal untuk <?= $ujian['nama_ujian'] ?></h1><br>
            <a href="/banksoal/<?= $id_mata_kuliah; ?>/detail_ujian/<?= $ujian['id']; ?>">Kembali ke Halaman Sebelumnya</a><br><br>
            <h4 id="selectedCount">0</h4>
            <form action="/banksoal/<?= $id_mata_kuliah; ?>/update_soal_ujian/<?= $ujian['id']; ?>" method="POST">
                <?php foreach ($bab as $bab) : ?>
                    <?php if ($bab['id_mata_kuliah'] == $id_mata_kuliah) : ?>
                        <div class="bab1">
                            <div class="bab-box" onclick="toggleSoalList(this)">
                                <div class="bab-title">
                                    <h4><?= $bab['nama_bab'] ?></h4>
                                </div>
                                <input type="checkbox" name="babs_<?= $bab['id'] ?>" value="<?= $bab['id'] ?>" onclick="checkAll(this)">
                            </div>
                            <ul class="soal-list">
                                <?php foreach ($soal as $s) : ?>
                                    <?php if ($s['id_bab'] == $bab['id']) : ?>
                                        <li>
                                            <?php
                                            $isChecked = ($soal_ujian2->getSoalFromSoalUjian($s['id'])) ? 'checked' : '';
                                            echo '<input type="checkbox" id="id_soal_' . $s['id'] . '" name="id_soal_' . $s['id'] . '" value="' . $s['id'] . '" ' . $isChecked . ' style="display: inline-block; margin-right: 10px;" onclick="updateSelectedCount()">' . $s['soal']; ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Ubah Soal Ujian</button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateBabBoxCheckbox(babBox) {
        var babCheckbox = babBox.querySelector('input[type="checkbox"][name^="babs_"]');
        var soalCheckboxes = babBox.querySelectorAll('input[name^="id_soal_"]');
        var allSoalChecked;
        for (var i = 0; i < soalCheckboxes.length; i++) {
            if (!soalCheckboxes[i].checked) {
                allSoalChecked = false;
                break;
            } else allSoalChecked = true;
        }

        babCheckbox.checked = allSoalChecked;
    }

    function toggleSoalList(element) {
        var soalList = element.nextElementSibling;
        var displayStyle = window.getComputedStyle(soalList).display;

        if (displayStyle === 'none') {
            soalList.style.display = 'block';
        } else {
            soalList.style.display = 'none';
        }

        updateSelectedCount();
        updateBabBoxCheckbox(element.closest('.bab1'));
    }

    function checkAll(ele) {
        var checkboxes = ele.closest('.bab1').querySelectorAll('input[name^="id_soal_"]');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
        }
        updateSelectedCount();
        event.stopPropagation();
        updateBabBoxCheckbox(ele.closest('.bab1'));
    }

    function updateSelectedCount() {
        var selectedCount = document.querySelectorAll('input[name^="id_soal_"]:checked').length;
        var counterText = selectedCount + " soal terpilih";
        document.getElementById('selectedCount').textContent = counterText;
    }
    document.addEventListener('change', function(event) {
        var target = event.target;
        if (target.matches('input[name^="id_soal_"]')) {
            updateBabBoxCheckbox(target.closest('.bab1'));
        }
    });
    window.onload = function() {
        updateSelectedCount();
        document.querySelectorAll(".bab1").forEach(bab1 => updateBabBoxCheckbox(bab1));
    }
</script>
<?= $this->endSection(); ?>