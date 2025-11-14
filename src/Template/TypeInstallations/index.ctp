<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeInstallation[]|\Cake\Collection\CollectionInterface $typeInstallations
 */
?>
<?php
	$titrePage = "Liste des type d'installations" ;
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

	// $this->start('actionTitle');
		// echo $this->Html->link('<i class="mdi mdi-plus-circle"></i> Create',['action'=>'add?type=1'],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-success", "style"=>"margin-left: 5px;" ]);
	// $this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
				<?= $this->Html->link(__('Create'),['action'=>'add?type=1'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success", "style"=>"margin-left: 5px;" ]); ?>
				<h4 class="card-title">Installations possibles</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
							<tr>
								<th scope="col"><?= $this->Paginator->sort('nom') ?></th>
								<th class="actions"></th>
							</tr>
                        </thead>
                        <tbody>
                        <?php foreach ($installations as $typeInstallation): ?>
							<tr>

								<td><?= $typeInstallation->nom ?></td>
								<td>
									<?= $this->Html->link('<i class="mdi mdi-pencil text-inverse"></i>', ['action' => 'edit', $typeInstallation->id], ['escape' => false]) ?>
									<?= $this->Form->postLink('<i class="mdi mdi-delete text-danger"></i>', ['action' => 'delete', $typeInstallation->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
								</td>
							</tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
				
				<?= $this->Html->link(__('Create'),['action'=>'add?type=0'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success", "style"=>"margin-left: 5px;" ]); ?>
				<h4 class="card-title">Désinstallations possibles</h4>
                <div class="table-responsive">
					<?php if(count($desinstallations)){ ?>
                    <table class="table">
                        <thead>
							<tr>
								<th scope="col"><?= $this->Paginator->sort('nom') ?></th>
								<th class="actions"></th>
							</tr>
                        </thead>
                        <tbody>
                        <?php foreach ($desinstallations as $typeInstallation): ?>
							<tr>

								<td><?= $typeInstallation->nom ?></td>
								<td>
									<?= $this->Html->link('<i class="mdi mdi-pencil text-inverse"></i>', ['action' => 'edit', $typeInstallation->id], ['escape' => false]) ?>
									<?= $this->Form->postLink('<i class="mdi mdi-delete text-danger"></i>', ['action' => 'delete', $typeInstallation->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
								</td>
							</tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
					<?php 
						}else{
							echo '<div class="alert alert-warning" style="margin-top: 15px;">'.__('No records.').'</div>';
						} 
					?>
                </div>
            </div>
        </div>
    </div>
</div>
