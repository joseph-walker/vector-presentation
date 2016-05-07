<?php

namespace Vector\Themes\Primer;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PrimerPagination
{
    public static function render(LengthAwarePaginator $paginator)
    {
        if ($paginator->hasPages()) : ?>
            <style>
                body {
                    padding: 15px;
                }

                .vector_primer_table {
                    margin-bottom: 10px;
                    border-top: 0;
                    border-radius: 3px;
                    color: #68777d;
                }
                .vector_primer_table_head {
                    position: relative;
                    padding: 6px;
                    margin-bottom: -1px;
                    line-height: 20px;
                    color: #68777d;
                    background-color: #eee;
                    background-image: linear-gradient(#fcfcfc, #eee);
                    border: 1px solid #d5d5d5;
                    border-radius: 3px;
                }
                .vector_primer_table_body {
                    border: 1px solid #ddd;
                }
                .vector_primer_table_head_row {
                    padding: 6px 3px;
                }
                .vector_primer_table_head_cell {
                    padding: 5px;
                    flex: 1;
                }
                .vector_primer_table_body_cell {
                    padding: 5px;
                    flex: 1;
                }
                .vector_primer_table_body_row:nth-child(even) {
                    background: #F5F5F5;
                }
                .vector_primer_table_body_row {
                    padding: 5px;
                }
            </style>
            
            <div style="text-align: center;padding: 15px;">
                <a href="<?= $paginator->previousPageUrl() ?>">
                    <button <?= $paginator->currentPage() > 1 ? '' : 'disabled' ?> class="btn btn-default">
                        Previous
                    </button>
                </a>
                <?php foreach (range(
                                   max($paginator->currentPage() - 4, 0) + 1,
                                   ($paginator->currentPage() + 3 < ceil($paginator->total() / $paginator->perPage()))
                                       ? ($paginator->currentPage() + 3)
                                       : ceil($paginator->total() / $paginator->perPage())
                               ) as $index) : ?>
                    <a href="<?= $paginator->url($index) ?>">
                        <button class="btn <?= $paginator->currentPage() == $index
                            ? 'btn-primary'
                            : 'btn-default' ?>">
                            <?= $index ?>
                        </button>
                    </a>
                <?php endforeach; ?>
                <a href="<?= $paginator->nextPageUrl() ?>">
                    <button <?= $paginator->nextPageUrl() ? '' : 'disabled' ?> class="btn btn-default">
                        Next
                    </button>
                </a>
            </div>
        <?php endif;
    }
}
