<table class="table">
    <thead>
    <tr>
        <th>Fichier</th>
        <th>Date import</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stripeCsvFiles as $stripeCsvFile):
    $file_name = explode(".", $stripeCsvFile->filename_origin)[0]; ?>
    <tr>
        <td><?= $this->Html->link($stripeCsvFile->filename_origin, $stripeCsvFile->url_viewer,["class"=>""]) ?></td>
        <td><?= $stripeCsvFile->date_import->format('d/m/Y H:i'); ?></td>
        <td>
            <?php if($stripeCsvFile->is_export_excel) { ?>
            <?= "Excel exporté" ?>
            <?php } else { ?>
            <?= $this->Html->link('Exporter le excel', ['action' => 'export', $stripeCsvFile->id, $file_name, '_ext'=>'xlsx']) ?>
            <?php } ?>
        </td>
        <td>
            <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $stripeCsvFile->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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