<?php $pager->setSurroundCount(10) ?>
<style>
    .equal-width-btn {
        width: 50px;
        text-align: center;
    }

</style>
<nav aria-label="Page navigation">
    <div class="pagination">
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