<?php

namespace Vector\Themes\Primer;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PrimerPagination
{
    public static function render(LengthAwarePaginator $paginator)
    {
        if ($paginator->hasPages()) : ?>
            <div style="text-align: center;padding: 15px;">
                <a href="<?= $paginator->previousPageUrl() ?>" class="btn btn-default <?= $paginator->currentPage() > 1 ? '' : 'disabled' ?>">
                    Previous
                </a>
                <?php foreach (range(
                                   max($paginator->currentPage() - 4, 0) + 1,
                                   ($paginator->currentPage() + 3 < ceil($paginator->total() / $paginator->perPage()))
                                       ? ($paginator->currentPage() + 3)
                                       : ceil($paginator->total() / $paginator->perPage())
                               ) as $index) : ?>
                    <a href="<?= $paginator->url($index) ?>" class="btn <?= $paginator->currentPage() == $index
                        ? 'btn-primary'
                        : 'btn-default' ?>">
                        <?= $index ?>
                    </a>
                <?php endforeach; ?>
                <a href="<?= $paginator->nextPageUrl() ?>" class="btn btn-default <?= $paginator->nextPageUrl() ? '' : 'disabled' ?>">
                    Next
                </a>
            </div>
        <?php endif;
    }
}
