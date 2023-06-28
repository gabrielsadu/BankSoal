<style>
    .equal-width-btn {
        width: 50px;
        text-align: center;
    }
</style>
<nav aria-label="Page navigation">
    <div class="pagination">
        <?php $pager->setSurroundCount(10) ?>
        <?php
        $counter = 0; // Counter to track the number of buttons
        foreach ($pager->links() as $link) :
            $counter++;
        ?>
            <div class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link equal-width-btn" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </div>
        <?php
            if ($counter % 5 == 0) {
                echo '</div><div class="pagination">';
            }
        endforeach;
        ?>
    </div>
</nav>
<br><br>
<nav aria-label="Page navigation">
    <?php $pager->setSurroundCount(0) ?>
    <ul class="pagination">
    <?php if ($pager->hasNext() && !$pager->hasPrevious()) : ?>
        <li class="page-item ml-auto"">
            <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true">Selanjutnya</span>
            </a>
        </li>
    <?php elseif (!$pager->hasNext() && $pager->hasPrevious()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                <span aria-hidden="true">Sebelumnya</span>
            </a>
        </li>
        <li class="page-item ml-auto"">
            <button type="submit" class="btn btn-primary">Selesai</button>
        </li>
    <?php elseif ($pager->hasNext() && $pager->hasPrevious()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                <span aria-hidden="true">Sebelumnya</span>
            </a>
        </li>
        <li class="page-item ml-auto"">
            <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true">Selanjutnya</span>
            </a>
        </li>
    <?php endif ?>
</ul>
</nav>