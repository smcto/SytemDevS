<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Borne $borne
 */
?>
<!-- Color picker plugins css -->
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>

<!-- Plugin for this page -->
<?= $this->Html->css('jquery-asColorPicker-master/asColorPicker.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('antennes/antenne.css?'.  time(), ['block' => true]) ?>
<!-- Plugin for this page -->


<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>

<?= $this->Html->script('antennes/view.js?' . time(), ['block' => true]); ?>

<?php

$horaire_accueil = json_decode($antenne->horaire_accueil,true);
$horaire = !empty($horaire_accueil)?$horaire_accueil['heurs']:null;

$titrePage = "Information Antenne" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Antennes',
    ['controller' => 'Antennes', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row">

        <div class="col-lg-6">
                    <div class="card">
                                <div class="card-body">
                                    
                                    <h3 class="card-title"><?= $antenne->ville_principale ?> <?= $antenne->sous_antenne?"(Sous antenne)":"" ?></h3>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="control-label col-md-6 <?= $antenne->sous_antenne?:"hide" ?>">Antenne Principale : </label>
                                        <div class="col-md-6 <?= $antenne->sous_antenne?:"hide" ?>">
                                            <?= $antenne->parent_antenne?$antenne->parent_antenne->ville_principale:"" ?>
                                        </div>
                                        <label class="control-label col-md-6">Type de lieu : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->lieu_type?$antenne->lieu_type->nom:"" ?>
                                        </div>
                                        <label class="control-label col-md-6">Adresse : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->adresse ?>
                                        </div>
                                        <label class="control-label col-md-6">Ville exacte : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->ville_excate ?>
                                        </div>
                                        <label class="control-label col-md-6">Cp : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->cp ?>
                                        </div>
                                        <label class="control-label col-md-6">Pays :</label>
                                        <div class="col-md-6">
                                            <?= $antenne->pays?$antenne->pays->name:"--" ?>
                                        </div>
                                        <label class="control-label col-md-6">Secteur Geographique :</label>
                                        <div class="col-md-6">
                                            <?= $antenne->secteur_geographique_id?@$secteur_geos[$antenne->secteur_geographique_id]:"--" ?>
                                        </div>
                                        <label class="control-label col-md-6">Email comercial : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->email_commercial ?>
                                        </div>
                                        <label class="control-label col-md-6">Telephone : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->telephone ?>
                                        </div>
                                        <label class="control-label col-md-6">Etat : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->etat?$antenne->etat->valeur:"--"; ?>
                                        </div>
                                        <label class="control-label col-md-6">Statut : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->statut?"Actif":"Inactif" ?>
                                        </div>
                                        <label class="control-label col-md-6 <?= $antenne->debit_internet_id?:"hide" ?>">Débit internet : </label>
                                        <div class="col-md-6 <?= $antenne->debit_internet_id?:"hide" ?>">
                                            <?= @$debit_internets[$antenne->debit_internet_id] ?>
                                        </div>
                                        <label class="control-label col-md-6">Identifiant page worpdress : </label>
                                        <div class="col-md-6">
                                            <?= $antenne->id_wp ?>
                                        </div>
                                </div>
                            
                                <h3 class="card-title">Localisation Google Maps</h3>
                                <hr>
                                <div class="form-group row hide">
                                    <div class="col-sm-6">
                                        <label class="control-label">Latitude</label><input id="txtLatitude" value="<?= $antenne->latitude ?>" >
                                     </div>
                                     <div class="col-sm-6">
                                        <label class="control-label">Longitude</label><input id="txtLongitude" value="<?= $antenne->longitude ?>" >
                                     </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                          <div id="mapCanvas" style="width:auto; height:250px;"></div>
                                            <div class="kl_infoForm"></div>
                                          <div class="error error-message kl_erreurLongLat hide"></div>
                                     </div>
                                </div>
                            
                            <div class="form-actions">
                                    <?= $this->Html->link('Edit Antenne',['controller' => 'Antennes', 'action' => 'edit', $antenne->id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?>
                            </div>
                        </div>
                </div>
        </div>
    
        <div class="col-lg-6">
            <div class="card">
                        <div class="card-body">

                        <h3 class="card-title">Horaires accueil / ouverture</h3>
                         <hr>          
                         <div id ="heurs">
                            <?php if($horaire_accueil!=null && $horaire_accueil['jours']=='tous_jours') : ?>
                                <div class="row"> 
                                        <div class="col-md-4 align-self-center">
                                             <label class="control-label">Tous les jours</label>
                                        </div> 
                                        <div class="col-md-4 align-self-center">
                                             <label class="control-label">Horaire début :  <?= !empty($horaire['debut'])?$horaire['debut']:'' ?></label>
                                        </div> 
                                        <div class="col-md-4 align-self-center">
                                             <label class="control-label">Horaire fin :  <?= !empty($horaire['fin'])?$horaire['fin']:'' ?></label>
                                        </div> 
                                </div>
                            <?php else : ?>
                                    <div class="form-group row mx-2">
                                            <table class="table table-bordered min-t">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0">Jour</th>
                                                        <th class="p-0">Horaire début</th>
                                                        <th class="p-0">Horaire fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $jours = ['lun' => 'Lundi','mar' => 'Mardi', 'mer' => 'Mercredi', 'jeu' => 'Jeudi', 'ven' => 'Vendredi', 'sam' => 'Samedi','dim' => 'Dimanche']; 
                                                    foreach ($jours as $key => $value) :
                                                    ?>
                                                    <tr>
                                                        <td><div class="mt-1 <?= !empty($horaire[$key])?'':'hide'; ?>"> <?= $value?></div></td>
                                                        <td><?= !empty($horaire[$key]['debut-1-'.$key])?$horaire[$key]['debut-1-'.$key]:'' ?></td>
                                                        <td><?= !empty($horaire[$key]['fin-1-'.$key])?$horaire[$key]['fin-1-'.$key]:'' ?></td>
                                                    </tr>
                                                    <tr class="<?=(empty($horaire[$key]['debut-2-'.$key])?'hide':'') ?>">
                                                        <td></td>
                                                        <td><?= !empty($horaire[$key]['debut-2-'.$key])?$horaire[$key]['debut-2-'.$key]:'' ?></td>
                                                        <td><?= !empty($horaire[$key]['fin-2-'.$key])?$horaire[$key]['fin-2-'.$key]:'' ?></td>
                                                    </tr>
                                                    <?php  endforeach; ?>
                                                </tbody>
                                            </table>
                                    </div>
                        <?php  endif; ?>
                         </div>

                        <h3 class="card-title">Précision Lieu</h3>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?= $antenne->precision_lieu; ?>
                             </div>
                        </div>
                        <h4 class="card-title">Commentaire antenne</h4>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?= $antenne->commentaire; ?>
                             </div>
                        </div>
                        
                        <?php if ($antenne->bornes) : ?>
                            <h3 class="card-title">Borne(s)</h3>
                            <hr>
                            
                            <?php foreach ($parcs as $key => $parc): ?>
                                <?php if ($parc->bornes): ?>
                                    <div class="clearfix mb-4">

                                        <?= $parc->nom ?> : <br>
                                        <?php $bornes = $parc->bornes ?>
                                        <?php $bornes = collection($parc->bornes)->sortBy('FormatNumero', SORT_ASC, SORT_NATURAL); ?>
                                        <?php $bornesClassik = $bornes->match(['model_borne.gamme_borne_id' => 2]); ?>
                                        <?php $bornesSpherik = $bornes->match(['model_borne.gamme_borne_id' => 3]); ?>

                                        <div class="pl-4">
                                            <?php if ($bornesClassik->count() > 0): ?>
                                                Classik : <br>
                                                <?php foreach ($bornesClassik as $key => $borne) : ?>
                                                    <?= $this->Html->link($borne->get('FormatNumero'), ['controller' => 'Bornes', 'action' => 'view' , $borne->id]) ?>,
                                                <?php endforeach; ?>
                                                <br>
                                            <?php endif ?>
                                            <?php if ($bornesSpherik->count() > 0): ?>
                                                Spherik : <br>
                                                <?php foreach ($bornesSpherik as $key => $borne) : ?>
                                                    <?= $this->Html->link($borne->get('FormatNumero'), ['controller' => 'Bornes', 'action' => 'view' , $borne->id]) ?>,
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        
                        <?php endif; ?>
                        
                        <?php if ($antenne->lot_produits) : ?>
                        <h3 class="card-title">Equipemement </h3>
                        <hr>
                        
                        <?php foreach ($antenne->lot_produits as $produit) : ?>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <?= @$produit->type_equipement->nom; ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= @$produit->equipement->valeur; ?><br>
                                    <?= '#' . @$produit->serial_nb; ?>
                                 </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php endif; ?>
                        
                        <?php if(count($antenne->fichiers)) : $i = 1?>
                        <h3 class="card-title">Photo(s) du lieu</h3>
                        <hr>
                        <div class="container">
                              
                                <?php  foreach ($antenne->fichiers as $image) : ?>
                                    <div class="mySlides">
                                        <div class="numbertext"><?= $i .'/'. count($antenne->fichiers) ?></div>
                                        <img src="../../../webroot/uploads/antenne/<?= $image->nom_fichier ?>" class="img-antenne">
                                    </div>
                                <?php endforeach; ?>

                                <?php if(count($antenne->fichiers) > 1) : ?>
                                    <a class="prev" onclick="plusSlides(-1)"><</a>
                                    <a class="next" onclick="plusSlides(1)">></a>
                                <?php endif; ?>

                        </div>
                        <?php  endif; ?>
                        
                    </div>

            </div>
        </div>
</div>