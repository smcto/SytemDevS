<table class="table kl_table">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('pipe_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
        <th scope="col"><?= $this->Paginator->sort('ordre') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pipeEtapes as $pipeEtape): ?>
    <tr  id="<?= $pipeEtape->id ?>">
        <td><?= $pipeEtape->has('pipe') ? $this->Html->link($pipeEtape->pipe->nom, ['action' => 'edit', $pipeEtape->id]) : '' ?></td>
        <td><?= $this->Html->link($pipeEtape->nom,['action'=>'edit',$pipeEtape->id ]) ?></td>
        <td><?= $this->Number->format($pipeEtape->ordre) ?></td>
        <td class="actions">
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pipeEtape->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pipeEtape->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6">
            <div class="text-right">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
            </div>
        </td>
    </tr>
    </tfoot>
</table>

<script>
        $('.kl_table').tableDnD({
            onDrop: function (table, row) {
                //alert(table.rows);
                var rows = [];
                $.each(table.rows, function (index, elem) {
                    var tr = $(elem);
                    var id = tr.attr('id');
                    rows[index] = id;
                    //console.log(tr);
                });
                rows.shift();
                console.log(rows);
                //console.log(rows.length);
                var BASE_URL = $('#id_baseUrl').val();
                $.ajax({
                    url: BASE_URL + "fr/pipeEtapes/getOrdre",
                    type: "POST",
                    data: {'new_list': rows},
                    success: function (data) {
                        //console.log(data);
                        $("#div_content_table").empty().html(data);
                        //window.location.href = BASE_URL + "categories";
                    }
                });
            }
        });
</script>