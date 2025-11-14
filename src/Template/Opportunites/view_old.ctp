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
'Dashboards',
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
                <div class="form-body">
                   <?php
                    echo $this->Form->create($opportunite);
                    echo $this->Form->control('created',['label'=>'Date de création','type'=>'text']);
                    echo $this->Form->control('id_in_sellsy',['label'=>'ID dans Sellsy']);
                    echo $this->Form->control('numero',['label'=>'Numéro']);
                    echo $this->Form->control('nom');
                    echo $this->Form->control('opportunite_statut_id', ['options' => $opportuniteStatuts, 'empty' => true,'label'=>'Statut']);
                    echo $this->Form->control('montant_potentiel',['label'=>'Potentiel']);
                    //echo $this->Form->control('date_echeance', ['empty' => true]);
                    echo $this->Form->control('pipeline_id', ['options' => $pipelines, 'empty' => true]);
                    echo $this->Form->control('pipeline_etape_id', ['options' => $pipelineEtapes, 'empty' => true,'label'=>'Etape']);
                    echo $this->Form->control('probabilite',['label'=>'Probabilité']);
                    echo $this->Form->control('brief',['id'=>'wysihtml5','rows'=>'15','type'=>'textarea','class' => 'form-control']);
                    echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true,'label'=>'Client']);
                    echo $this->Form->control('type_client_id', ['options' => $typeClients, 'empty' => true,'label'=>'Type de client']);
                    echo $this->Form->control('source_lead_id', ['options' => $sourceLeads, 'empty' => true,'label'=>'Comment avez-vous connu Selfizee']);
                    echo $this->Form->control('contact_raison_id', ['options' => $contactRaisons, 'empty' => true,'label' => 'Contat pour']);
                    echo $this->Form->control('type_evenement_id', ['options' => $typeEvenements, 'empty' => true,'label' => 'Type d\'événement']);
                    echo $this->Form->control('type_demande',['label'=>'Type de demande']);
                    echo $this->Form->control('antenne_retrait',['label'=>'Antenne retrait']);
                    echo $this->Form->control('antenne_retrait_secondaire',['label'=>'Antene retrait secondaire']);
                    echo $this->Form->end();
                   ?>
                    <?php if(!empty($opportunite->linked_docs)){ ?>
                    <h3 class="box-title m-t-40">Documents liés</h3><hr>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Staut</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($opportunite->linked_docs as $doc){?>
                        <tr>
                            <td><?= $doc->ident_in_sellsy ?></td>
                            <td><?= $doc->step_label ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
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




