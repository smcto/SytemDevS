<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsvFile[]|\Cake\Collection\CollectionInterface $stripeCsvFiles
 */
?>

<?= $this->Html->script('bornes/refresh.js', ['block' => true]); ?>

<?php
$titrePage = "Liste des fichiers csv importés" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link(__('Importer'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="div_table_file_csv">
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
                            <td>
                                <?= $this->Html->link($stripeCsvFile->filename_origin, $stripeCsvFile->url_viewer,["class"=>""]) ?>
                            </td>
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
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>

</div>
