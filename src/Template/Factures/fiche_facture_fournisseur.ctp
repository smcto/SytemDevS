<?php $this->Html->css('/scss/icons/font-awesome/css/font-awesome.css', ['block' => 'css']); ?>
<?php
    $this->assign('title', 'Fiche facture fournisseur');
    $titrePage = "Fiche facture fournisseur" ;
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );

    $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();

    $this->start('actionTitle');
    $this->end();
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2>Détail <?= $facture->titre ?> de <?= $facture->fournisseur->nom ?></h2>
                Date facture : <?= $facture->created->format('d/m/Y') ?>

                <h4 class="my-4">Récap :</h4>
                <table class="table table-bordered">
                    <tbody>
                        <?php foreach ($groupedEquipements as $key => $groupedEquipement): ?>
                            <tr>
                                <td>
                                    <?= $qtyEquipement = $groupedEquipement->qtyEquipement ?> 
                                    <?= mb_strtolower($groupedEquipement->type_equipement->nom) . ($qtyEquipement > 1 ? 's' : '') ?> 
                                    <?= $groupedEquipement->equipement->valeur ?> : <?= $groupedEquipement->parc->nom ?> <br>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <h4 class="my-4">Détail :</h4>

                <table class="table table-bordered table-hover">
                    <tbody>
                        <thead>
                            <tr>
                                <th width="90%" colspan="3">Description</th>
                                <th width="10%" class="text-center">Quantité</th>
                            </tr>
                        </thead>
                        <?php foreach ($groupedTypeEquipements as $key => $groupedTypeEquipement): ?>
                            <tr class="bg-light">
                                <td colspan="4"><b>
                                    <?= $groupedTypeEquipement->type_equipement->nom ?>
                                    <?= $groupedTypeEquipement->equipement->valeur ?></b> <br>
                                </td>
                            </tr>

                            <?php foreach ($groupedTypeEquipement->factures_produits as $parc => $factures_produits): ?>
                                <tr>
                                    <td></td>
                                    <td colspan="3"><span class="fa fa-angle-right"></span> <?= $parc ?></td>
                                </tr>
                                
                                <?php foreach ($factures_produits as $key => $produit): ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            - <?= $produit->equipement->valeur ?> <?php $produit->equipement->marque_equipement->marque ?> :
                                            <?php if (!empty($produit->equipement->bornes)): ?>
                                                borne n° <?= join(' , borne n° ', collection($produit->equipement->bornes)->extract('numero')->toArray()) ?>
                                            <?php else: ?>
                                                aucune borne associée au produit
                                            <?php endif ?>
                                        </td>
                                        <td class="text-center"><?= $produit->qty ?></td>
                                    </tr>
                                <?php endforeach ?>
                                <tr></tr>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
