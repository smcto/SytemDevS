<?php $this->Html->css('/scss/icons/flaticon/flaticon.css', ['block' => 'css']); ?>
<?php $this->Html->css('/scss/icons/flaticon2/flaticon.css', ['block' => 'css']); ?>
<?php $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?php $this->Html->css('ventes/fiche', ['block' => 'css']); ?>

<?php $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php $this->Html->script('ventes/fiche.js?time='.time(), ['block' => 'script']); ?>
<?php 
    $titrePage = "Fiche de vente" ;
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'add'] );
        $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => 'Clients et facturation']);
    $this->end();

    if ($vente_mode == null || @$modemarker == 1) {
        $this->assign('custom_title', 'Création vente');
    }
?>

<div class="">
    <div class="card m-0">
        <div class="card-body">
            <div class="row align-items-center etap-crea-vente-container">
                <div class="col py-4">
                    <a href="<?= $this->Url->build(['action' => 'add'], true) ?>" class="<?= isset($modemarker) && $modemarker == 1 ? 'active' : '' ?>">
                        <div class="d-none">
                            <span class="mr-auto flaticon-folder-1 fa-3x"></span>
                            <div class="d-inline-block my-auto"><span class="flex-row-reverse flaticon2-right-arrow"></span></div>
                        </div>
                        <div class="titre-client">1 - CLIENT</div>
                    </a>
                </div>  
                <div class="col py-4">
                    <a href="<?= $this->Url->build(['action' => 'materiel'], true) ?>" class="">
                        <div class="d-none">
                            <span class="mr-auto flaticon-open-box fa-3x"></span>
                            <div class="d-inline-block my-auto"><span class="flex-row-reverse flaticon2-right-arrow"></span></div>
                        </div>
                        <div>2 - MATERIEL</div>
                    </a>
                </div>

                <div class="col py-4">
                    <a href="<?= $this->Url->build(['action' => 'optionsConsommables'], true) ?>" class="">
                        <div class="d-none">
                            <span class="mr-auto flaticon-open-box fa-3x"></span>
                            <div class="d-inline-block my-auto"><span class="flex-row-reverse flaticon2-right-arrow"></span></div>
                        </div>
                        <div class="titre-options">3 - OPTIONS</div>
                    </a>
                </div>

                <div class="col py-4">
                    <a href="<?= $this->Url->build(['action' => 'briefProjet'], true) ?>" class="">
                        <div class="d-none">
                            <span class="mr-auto flaticon-cogwheel fa-3x"></span>
                            <div class="d-inline-block my-auto"><span class="flex-row-reverse flaticon2-right-arrow"></span></div>
                        </div>
                        <div>4 - CREA / CONFIG</div>
                    </a>
                </div>
                <div class="col py-4">
                    <a href="<?= $this->Url->build(['action' => 'livraison'], true) ?>" class="">
                        <div class="d-none">
                            <span class="mr-auto flaticon-truck fa-3x"></span>
                            <div class="d-inline-block my-auto"><span class="flex-row-reverse flaticon2-right-arrow"></span></div>
                        </div>
                        <div>5 - LIVRAISON</div>
                    </a>
                </div>
                <div class="col py-4">
                    <a href="<?= $this->Url->build(['action' => 'recap'], true) ?>" class="">
                        <div class="d-none">
                            <span class="mr-auto flaticon-list-1 fa-3x"></span>
                        </div>
                        <div>6 - RECAP</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4"><?= $this->fetch('content') ?></div>
    
    <?php $this->start('bloc_btn') ?>
        <div class="float-right">
            <a href="<?= $this->Url->build(['controller' => 'ventes', 'action' => 'recap', 'save']) ?>" class="btn btn-rounded btn-primary save_vente">Enregistrer</a>
            <a href="<?= $this->Url->build(['controller' => 'ventes', 'action' => 'index']) ?>" class="btn btn-rounded btn-inverse">Quitter</a>
        </div>
    <?php $this->end() ?>
</div>