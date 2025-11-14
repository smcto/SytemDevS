<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeInstallation $typeInstallation
 */
?>

<?php
$titre = ($this -> request -> getQuery('type') == 0) ? 'désinstallation' : 'installation';
$type = (in_array($this -> request -> getQuery('type'), array(0, 1))) ? $this -> request -> getQuery('type') : 1;
$titrePage = "Ajout d'une nouvelle ".$titre ;
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
			<div class="card-body">
				<?= $this->Form->create($typeInstallation) ?>
				<div class="form-body">
					<h3 class="card-title"><?= $titre; ?></h3>
					<hr>
					<div class="form-group row">
						<div class="col-md-3">
							<?php echo $this->Form->control('nom'); ?>
						</div>
					</div>
					<div class="hide">
						<?php echo $this->Form->control('type', ['value' => $type]); ?>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<?php echo $this->Form->control('commentaire'); ?>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
