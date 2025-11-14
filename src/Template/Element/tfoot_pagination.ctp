<?php $count = (int) @$this->Paginator->params()['count']; ?>

<div class="dt-pagination-wrapper">
    <div class="number-info-wrap">
        <?= $this->Paginator->counter('Affichage {{start}} à {{end}} sur {{count}} éléments');?>
    </div>
    <div class="page-number-list-wrap">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>
