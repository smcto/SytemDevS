<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Facture $facture
 */
?>

<?= $this->Html->script('factures/factures.js',['block'=>true]) ?>
<?php
$titrePage = "Edition facture" ;
$this->start('breadcumb');
if(in_array("admin", $user_connected["typeprofils"])) {
$this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index']);
} else
if(in_array("antenne", $user_connected["typeprofils"])) {
$this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'antennes']);
} else
if(in_array("installateur", $user_connected["typeprofils"])) {
$this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'installateurs']);
}
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
                <?= $this->Form->create($facture, ['type' => 'file']) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Date : </label> <?php if(!empty($facture->created)) echo $facture->created->format('d/m/Y') ;?>
                            <?php //echo $this->Form->control('titre',['label' => 'Titre','type'=>'text']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Titre : </label> <?php echo $facture->titre ;?>
                            <?php //echo $this->Form->control('titre',['label' => 'Titre','type'=>'text']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Expéditeur : </label> <?php echo $facture->user->full_name ;?>
                            <?php //echo $this->Form->control('user_id',['label' => 'Expéditeur ','type'=>'text', 'value'=>$facture->user->full_name]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Antenne : </label> <?php if(!empty($facture->user->antenne)) echo $facture->user->antenne->ville_principale ;?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Montant : </label> <?php echo $facture->montant ;?> €
                            <?php //echo $this->Form->control('montant',['label'=>'Montant', 'type'=>'number']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fichier :</label><br>
                            <?php
                                if(!empty($facture->url) && file_exists(PATH_FACTURES.$facture->nom_fichier)) {
                                    $extension = pathinfo($facture->url, PATHINFO_EXTENSION);
                                    $extensionsImg = array('png', 'gif', 'jpg', 'jpeg');
                                    if($extension == "pptx") { $extension = "powerpoint";}
                                    if($extension == "docx") { $extension = "word";}
                                    if(in_array($extension, $extensionsImg)) {
                                         echo $this->Html->link($this->Html->image($facture->url,['width' => 100, 'heigth'=>100]), $facture->url,['escape' => false, 'target'=>'_blank']);
                                      } else {
                                         echo $this->Html->link('<span><i class="fa fa-file-'.$extension.'-o fa-5x"></i></span>', $facture->url,['escape' => false,"class"=>"", 'target'=>'_blank']);
                                    }
                                }
                            ?>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-6">
                            <?php  $etats = ['attente_de_traitement'=>'En attente', 'accepte'=>'Accepté', 'refuse'=>'Refusé'];
                            //echo $this->Form->control('etat', ['label' => 'Etat : ' ,'options'=>$etats, 'class'=>'form-control' ,'empty'=>'Sélectionner un etat'] );?>
                            <?php echo $this->Form->control('etat_facture_id', ['label' => 'Etat', 'options' => $etatFactures, 'empty'=>'Sélectionner un etat', 'id'=>'etat_facture_id']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('message_type_facture_id', ['label' => 'Message type', 'options' => $messageTypeFactures,'empty'=>'Sélectionner un message', 'id'=>'message_type_id']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('commentaire',['label'=>'Commentaire :', 'type'=>'textarea', 'id'=>'message_id']); ?>
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


