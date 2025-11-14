<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Messagery $messagery
 */
?>

<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('messagerie/messagerie.js', ['block' => true]); ?>

<?php
$titrePage = "Envoi SMS" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Informations</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($messagery) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('destinateur',['label'=>'Destinateur ',"class"=>"form-control", 'required'=>false]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('users._ids',[
                            'type' => 'select',
                            'label' => 'Utilisateur(s) : ',
                            'options'=>$users,
                            'multiple' => true,
                            'required'=>false,
                            'data-placeholder'=>'Sélectionner',
                            "class"=>"select2 form-control select2-multiple",
                            'id'=>'']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('clients._ids',[
                            'type' => 'select',
                            'label' => 'Client(s) : ',
                            'options'=>$clients,
                            'multiple' => true,
                            'required'=>false,
                            'data-placeholder'=>'Sélectionner',
                            "class"=>"select2 form-control select2-multiple",
                            'id'=>'']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('message',['label'=>'Message *', 'required'=>true, "class"=>"form-control", "rows"=>"6",'type'=>'textarea']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('is_test',['label'=>'Est-ce qu\'un SMS de test ?',"class"=>"form-control"]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Envoyer'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>