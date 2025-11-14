<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur[]|\Cake\Collection\CollectionInterface $typeFournisseurs
 */
?>
<?= $this->Html->script('tablednd/jquery.tablednd.js',['block'=>true]) ?>
<?= $this->Html->script('pipe_etapes/order.js',['block'=>true]) ?>
<?php
$titrePage = "Liste des étapes" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
        'Réglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);
$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
    echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-body">
                    <div class="row">
                        <?php
                                echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);
                                //echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);

                                echo $this->Form->control('pipe', ['label' => false ,'options'=>$pipes, 'value'=> $pipe, 'class'=>'form-control' ,'empty'=>'Séléctionnez un pipe'] );

                                echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary','style'=>'margin: 0 10px 0 10px'] );
                                echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false,'style'=>'margin: 0 10px 0 0']);

                                echo $this->Form->end();
                                ?>
                    </div>
                </div>
                <div class="table-responsive" id="div_content_table">
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
                                <tr id="<?= $pipeEtape->id ?>">
                                    <td><?= $pipeEtape->has('pipe') ? $this->Html->link($pipeEtape->pipe->nom, ['action' => 'edit', $pipeEtape->id]) : '' ?></td>
                                    <td><?= $this->Html->link($pipeEtape->nom,['action'=>'edit',$pipeEtape->id ]) ?></td>
                                    <td><?= $this->Number->format($pipeEtape->ordre) ?></td>
                                    <td class="actions">
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pipeEtape->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pipeEtape->id)]) ?>
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
<!--
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
            url: BASE_URL + "pipeEtapes/getOrdre",
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
</script>-->
