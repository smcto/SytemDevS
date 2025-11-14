<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evenement $evenement
 */
?>

<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('opportunites/view.js', ['block' => true]); ?>

<?php
$titrePage = "Détail opportunité" ;
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
                <h4 class="m-b-0 text-white">Informations générales</h4>
            </div>
            <div class="card-body">
                <div class="text-muted">Date de création</div>
                <h6><?= $opportunite->created ?></h6>

                <div class="text-muted">Numéro</div>
                <h6><?= $opportunite->numero ?></h6>

                <div class="text-muted">Nom</div>
                <h6><?= $opportunite->nom ?></h6>

                <div class="text-muted">Statut</div>
                <h6><?= @$opportunite->opportunite_statut->nom ?></h6>

                <div class="text-muted">Potentiel</div>
                <h6><?= $opportunite->montant_potentiel ? $this->Number->currency($opportunite->montant_potentiel) : '0 €' ?></h6>

                <div class="text-muted">Pipeline</div>
                <h6><?= @$opportunite->pipeline->nom ?></h6>

                <div class="text-muted">Etape</div>
                <h6><?= @$opportunite->pipeline_etape->nom ?></h6>

                <div class="text-muted">Probabilité</div>
                <h6><?= $opportunite->probabilite ?></h6>

                <div class="text-muted">Brief</div>
                <div><?= $opportunite->brief ?></div>

                <div class="text-muted">Client</div>
                <h6><?= $this->Html->link(@$opportunite->client->full_name,['controller'=>'Clients','action'=>'add',@$opportunite->client->id]) ?></h6>

                <div class="text-muted">Type de Client</div>
                <h6><?= @$opportunite->type_client->nom?></h6>

                <div class="text-muted">Comment avez-vous connu Selfizee</div>
                <h6><?= @$opportunite->source_lead->nom ?></h6>

                <div class="text-muted">Contat pour</div>
                <h6><?= @$opportunite->contact_raison->nom ?></h6>

                <div class="text-muted">Type d'événement</div>
                <h6><?= @$opportunite->type_evenement->nom ?></h6>

                <div class="text-muted">Type de demande</div>
                <h6><?= $opportunite->type_demande ?></h6>

                <div class="text-muted">Antenne retrait</div>
                <h6><?= $opportunite->antenne_retrait ?></h6>

                <div class="text-muted">Antenne retrait secondaire</div>
                <h6><?= $opportunite->antenne_retrait_secondaire ?></h6>

                <div class="form-body">
                    <?php if(!empty($opportunite->linked_docs)){ ?>
                    <h3 class="box-title m-t-40">Documents liés</h3><hr>
                    <?= $this->element('Opportunites/doc_opportunite') ?>
                    <?php } ?>

                    <?php if(!empty($opportunite->opportunite_commentaires)){ ?>
                        <h3 class="box-title m-t-40">
                            <?= $opportunite->opportunite_commentaires>1 ? 'Commentaires' :'Commentaire' ?>
                        </h3>
                        <hr>
                        <?php 
                        foreach ($opportunite->opportunite_commentaires as $commentaire) { ?>
                            <div class="sl-item">
                                <div class="sl-left"> 

                                </div>
                                <div class="sl-right">
                                    <div>
                                        <a href="#" class="link" ><?= $commentaire->titre ?></a>
                                        <span class="sl-date"><?= date('d-m-Y H:i', $commentaire->timestamp) ?></span>
                                        <p class="m-t-10"><?= $commentaire->commentaire ?></p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    <?php } ?>
                </div> 
            </div>
        </div>
    </div>
</div>