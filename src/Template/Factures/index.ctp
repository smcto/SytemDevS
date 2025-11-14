<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Facture[]|\Cake\Collection\CollectionInterface $factures
 */
  use Cake\I18n\Number;
?>
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>

<?php
$titrePage = "Liste des factures" ;
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

$this->start('actionTitle');
if(!in_array("admin", $user_connected["typeprofils"])
&& ( in_array("installateur", $user_connected["typeprofils"]) || in_array("antenne", $user_connected["typeprofils"]) )) {
    echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
}
$this->end();

?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="form-body">
                    <div class="row">
                        <?php $etats = ['attente_de_traitement'=>'En attente', 'accepte'=>'Accepté', 'refuse'=>'Refuse'];
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);
                        echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);
                        echo $this->Form->control('etat', ['label' => false ,'options'=>$etatFactures, 'value'=> $etat, 'class'=>'form-control' ,'empty'=>'Etat'] );
                        if(in_array("admin", $user_connected["typeprofils"])) {
                        echo $this->Form->control('antenne', ['label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Antenne'] );
                        ?>
                        <input type="date" name="date_debut" class="form-control" placeholder="dd/mm/yyyy" id="date_debut"
                               value="<?php if(!empty($date_debut)) echo $date_debut ?>" > à
                        <input type="date" name="date_fin" class="form-control" placeholder="dd/mm/yyyy" id="date_fin"
                               value="<?php if(!empty($date_fin)) echo $date_fin ?>">
                        <?php } ?>
                        <?php
                        echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );
                        echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);

                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if(in_array("admin", $user_connected["typeprofils"]) || in_array("antenne", $user_connected["typeprofils"])) { ?>
    <div class="col-lg-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php if ($nbTotal > 1) { echo "Reçues" ;} else { echo "Reçue" ;} ?></h5>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><i></i><?= $nbTotal ?></h2>
                    <span class="text-muted"><?= $this->Number->currency($montantTotal, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php if ($nbTotalRegle > 1) { echo "Reglé" ;} else { echo "Reglé";} ?></h5>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><i></i><?= $nbTotalRegle ?></h2>
                    <span class="text-muted"><?= $this->Number->currency($montantTotalRegle, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php if ($nbTotalAregler > 1) { echo "A regler" ;} else { echo "A regler";} ?></h5>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><i ></i><?= $nbTotalAregler ?></h2>
                    <span class="text-muted"><?= $this->Number->currency($montantTotalAregler, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php if ($nbTotalEnAttente > 1) { echo "En attente" ;} else { echo "En attente";} ?></h5>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><i ></i><?= $nbTotalEnAttente ?></h2>
                    <span class="text-muted"><?= $this->Number->currency($montantTotalEnAttente, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php if ($nbTotalRefuse > 1) { echo "Réfusées" ;} else { echo "Réfusée";} ?></h5>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><i></i><?= $nbTotalRefuse ?></h2>
                    <span class="text-muted"><?= $this->Number->currency($montantTotalRefuse, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Expéditeur</th>
                            <th scope="col">Antenne(s)</th>
                            <th scope="col">Projet</th>
                            <th scope="col">Etat</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($factures as $facture): ?>
                        <tr>
                            <td>
                                <?php if(!empty($facture->created)) {
                                    if(in_array("admin", $user_connected["typeprofils"])) {
                                        echo $this->Html->link($facture->created->format('d/m/Y H:i'), ['action' => 'edition', $facture->id]);
                                    } else {
                                        echo $this->Html->link($facture->created->format('d/m/Y H:i'), ['action' => 'edit', $facture->id]);
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $facture->titre;?>
                                <br><small class="text-muted"><?= $this->Number->currency($facture->montant, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                            </td>
                            <td><?php echo $facture->user->full_name ;?></td>
                            <!--<td><?php //if(!empty($facture->user->antenne)) echo $facture->user->antenne->ville_principale ;?></td>-->
                            <td>
                                <?php //debug($facture->user->antennes_rattachees);die;
                                        $antennes = [];
                                        if(!empty($facture->user->antennes_rattachees)){
                                            foreach ($facture->user->antennes_rattachees as $antenne) {
                                                if(in_array("admin", $user_connected["typeprofils"])) {
                                                    $antennes [] = $this->Html->link($antenne->ville_principale, ['controller' => 'Antennes', 'action'=>'view', $antenne->id]);
                                                } else {
                                                    $antennes [] = $antenne->ville_principale;
                                                }
                                            }
                                        }
                                        echo implode(', ', $antennes);
                                ?>
                            </td>
                            <td><?php if(!empty($facture->evenement)) echo $facture->evenement->nom_event ?></td>
                            <?php $etats = ['1'=>'warning', '2'=>'success', '3'=>'danger', '4'=>'info',  ]?>
                            <td><span class="label label-light-<?= $etats[$facture->etat_facture->id] ?>"><?= $facture->etat_facture->nom ?></span></td>
                            <td><?php
                                    echo $this->Html->link( '<i class="fa fa-eye"></i>', $facture->url, ["escape"=>false,'class'=>' btn btn-sm btn-info', 'target'=>'_blank']);
                                    if($facture->etat_facture->id == 1 && in_array("admin", $user_connected["typeprofils"])) {
                                        echo $this->Html->link( 'Valider',
                                        ['controller' => 'Factures', 'action' => 'validate', $facture->id],
                                        ["escape"=>false,'class'=>' btn btn-sm btn-rounded btn-success']
                                        );
                                        echo $this->Html->link( '<i class="fa fa-ban"></i> Refuser',
                                        ['controller' => 'Factures', 'action' => 'refuse', $facture->id],
                                        ["escape"=>false,'class'=>' btn btn-sm btn-danger']
                                        );
                                    }
                                  ?>
                            </td>

                            <?php if(!in_array("admin", $user_connected["typeprofils"])
                                    && ( in_array("installateur", $user_connected["typeprofils"])
                                    || in_array("antenne", $user_connected["typeprofils"]) )) { ?>
                            <td>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $facture->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                            </td>
                            <?php } ?>
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
