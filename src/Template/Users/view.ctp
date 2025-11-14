<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('bornes/viewborne.js', ['block' => true]); ?>


<?php
$titrePage = "Détail d'un utilisateur";
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link('<i class="mdi mdi-login"></i> Se connecter',['action'=>'login', $user->id],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-success" ]);
echo $this->Html->link('<i class="mdi mdi-pencil-circle"></i> Edit',['action'=>'edit', $user->id, $user->group_user],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-success", "style"=>"margin-right:5px;" ]);
$this->end();

?>
<div class="row">

    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30"> <?= $this->Html->image($user->url_photo,['width' => 150, 'class'=>'img-circle']) ?>
                    <h4 class="card-title m-t-10"><?= $user->full_name ?></h4>
                    <h6 class="card-subtitle"><?php if(!empty($user->situation)) echo $user->situation->titre ;?></h6>
                    <p class="m-t-30"><small class="text-muted"><?php echo $user->description_rapide ;?></small></p>
                    <?= $this->Form->button('<i class="mdi mdi-email"></i>'.' Envoyer email',["type"=>"button", "class"=>"btn btn-xs btn-inverse",'escape'=>false, 'id'=>'btn_sendçemail_user',
                    'data-toggle'=>'modal', 'data-target'=>'#emailModal']) ?>
                    <?= $this->Form->button('<i class="mdi mdi-message-text"></i>'.' Envoyer sms',["type"=>"button", "class"=>"btn btn-xs btn-inverse",'escape'=>false, 'id'=>'btn_sendçemail_user',
                    'data-toggle'=>'modal', 'data-target'=>'#smsModal']) ?>

                    <!--<div class="row text-center justify-content-md-center">
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                    </div>-->
                </center>
            </div>
                <hr>
            <div class="card-body">
                <small class="text-muted">Type(s) profil(s)</small>
                <h6>
                    <?php $typeProfils = []; $typeprofils =[];
                            if(!empty($user->profils)){
                            foreach ($user->profils as $typeProfil) {
                            $typeProfils [] = $typeProfil->nom;
                            $typeprofils [] = $typeProfil->id;
                            }
                            }
                            echo implode(', ', $typeProfils);
                            //debug($typeprofils);
                    ?>
                </h6>
                <?php if(!empty($user->antennes_rattachees)) { ?>
                <small class="text-muted  p-t-30 db">Antenne(s) rattachée(s)</small>
                <h6>
                    <?php
                        $antennes = [];
                        if(!empty($user->antennes_rattachees)){
                            foreach ($user->antennes_rattachees as $antenne) {
                                $antennes [] = $antenne->ville_principale;
                            }
                        }
                        echo implode(', ', $antennes);
                    ?>
                </h6>
                <h6 class="hide"><?php if(!empty($user->antenne->latitude)) echo $this->Form->control('latitude',["id"=>"txtLatitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$user->antenne->latitude]);?></h6>
                <h6 class="hide"><?php if(!empty($user->antenne->latitude)) echo $this->Form->control('longitude',["id"=>"txtLongitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$user->antenne->longitude]);?></h6>
                <?php } ?>
                <small class="text-muted  p-t-30 db">Adresse email</small>
                <h6><?= $user->email ?></h6>
                <small class="text-muted p-t-30 db">Téléphone</small>
                <h6><?= $user->telephone_portable ?></h6>
                <small class="text-muted p-t-30 db">Adresse</small>
                <h6><?= $user->adresse." ". $user->cp." ".$user->ville." ". $user->pays->name_fr ?></h6>
                <!--<div class="map-box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                </div> <small class="text-muted p-t-30 db">Social Profile</small>
                <br>
                <button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
                <button class="btn btn-circle btn-secondary"><i class="fa fa-twitter"></i></button>
                <button class="btn btn-circle btn-secondary"><i class="fa fa-youtube"></i></button>-->
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-xlg-9 col-md-7">

        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#evenement" role="tab">Evenements</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#facture" role="tab">Factures</a> </li>
                <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a> </li>-->
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                <br>
                                <p class="text-muted"><?= $user->full_name ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                <br>
                                <p class="text-muted"><?= $user->telephone_portable ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                <br>
                                <p class="text-muted"><?= $user->email ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Location</strong>
                                <br>
                                <p class="text-muted"><?= $user->pays->name_fr ?></p>
                            </div>
                        </div>
                        <hr>
                        <?php if(in_array(4, $typeprofils) || in_array(5, $typeprofils) || in_array(6, $typeprofils) || in_array(7, $typeprofils) || in_array(8, $typeprofils) || in_array(9, $typeprofils)) { ;?>
                        <div class="row">
                            <?php  if(!empty($user->source)) { ?>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Source</strong>
                                <br>
                                    <?php $sources = ['ami'=>'Ami','famille'=>'Famille','reseaux_pro'=>'Réseaux pro', 'reseaux_sociaux'=>'Réseaux sociaux','prospection'=>'Prospection','autre'=>'Autres']; ?>
                                            <p class="text-muted"><?= $sources[$user->source] ?></p>
                            </div>
                            <?php } ;?>

                            <?php  if(!empty($user->commentaire_interne)) { ?>
                            <div class="col-md-6 col-xs-6 b-r"> <strong>Commentaire interne</strong>
                                <br>
                                <p class="text-muted"><?= $user->commentaire_interne ?></p>
                            </div>
                            <?php } ;?>

                            <?php  if(!empty($user->niveau_tech_info)) { ?>
                            <?php if(in_array(4, $typeprofils) || in_array(5, $typeprofils)) { ;?>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Niveau technique informatique</strong>
                                <br>
                                <?php $niveaux = ['expert'=>'Expert', 'bonnes_connaissances'=>'Bonnes connaissances', 'moyen'=>'Moyen', 'debutant'=>'Débutant']; ?>
                                <p class="text-muted"><?= $niveaux[$user->niveau_tech_info] ?></p>
                            </div>
                            <?php } ;?>
                            <?php } ;?>
                        </div>
                        <hr>
                        <?php } ;?>

                        <?php if(in_array(6, $typeprofils) || in_array(5, $typeprofils)) { ;?>
                        <div class="row">
                            <?php  if(!empty($user->vehicule)) { ?>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Vehicule</strong>
                                <br>
                                <p class="text-muted"><?= $user->vehicule ?></p>
                            </div>
                            <?php } ;?>
                            <?php  if(!empty($user->capacite_chargement_borne)) { ?>
                            <div class="col-md-6 col-xs-6 b-r"> <strong>Capacité</strong>
                                <br>
                                <p class="text-muted"><?= $user->capacite_chargement_borne ?></p>
                            </div>
                            <?php } ;?>
                            <?php  if(!empty($user->creneaux_disponibilite)) { ?>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Créneaux de dispo</strong>
                                <br>
                                <p class="text-muted"><?= $user->creneaux_disponibilite ?></p>
                            </div>
                            <?php } ;?>
                        </div>
                        <hr>
                        <?php } ;?>
                        <?php if(in_array(6, $typeprofils) || in_array(5, $typeprofils)) { ;?>
                        <div class="row">
                            <?php  if(!empty($user->creneaux_indisponibilite)) { ?>
                            <div class="col-md-3 col-xs-6"> <strong>Créneaux d'indispo</strong>
                                <br>
                                <p class="text-muted"><?= $user->creneaux_indisponibilite ?></p>
                            </div>
                            <?php } ;?>
                            <?php  if(!empty($user->zone_intervention)) { ?>
                            <div class="col-md-6 col-xs-6"> <strong>Zone d'intervention</strong>
                                <br>
                                <p class="text-muted"><?= $user->zone_intervention ?></p>
                            </div>
                            <?php } ;?>
                        </div>
                        <hr>
                        <?php } ;?>

                        <?php if(!empty($user->antenne)) { ?>
                        <div class="form-group row">
                            <div class="hide">
                                <label class="control-label">Adresse *</label>
                                <div id="infoPanel"><?php echo $this->Form->control('adresse',['label' => false,'class'=>'form-control controls','id'=>'searchTextField']);?></div>
                                <input id="info" type="text" size="50" value="" class="hide" />
                            </div>
                            <div class="col-md-12">
                                <div id="mapCanvas" style="width:auto; height:350px;"></div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-pane" id="evenement" role="tabpanel">
                    <div class="card-body">
                        <div class="profiletimeline0">
                            <?php if(!empty($interventions)){ ?>
                            <div class="sl-item">
                                <!--<div class="sl-left">Factures &lt;!&ndash;<img src="../assets/images/users/1.jpg" alt="user" class="img-circle">&ndash;&gt; </div>-->
                                <div class="sl-right">
                                    <div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Nom</th>
                                                            <th>Antenne</th>
                                                            <th>Client</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $clientType = ['corporation'=>'Pro' , 'person'=>'Part' ];if(!empty($interventions)){ ?>
                                                        <?php foreach ($interventions as $evenement){ ?>
                                                        <tr>
                                                            <td><?php $dates = [];
                                                                    if(!empty($evenement->date_evenements)) {
                                                                    foreach($evenement->date_evenements as $date_event) {
                                                                    $dates [] = $date_event->date_debut->format('d/m/y')." - ".$date_event->date_fin->format('d/m/y');
                                                                    }
                                                                    echo '<small class="text-muted">'.implode('; ',  $dates).'</small>';
                                                                    }?>
                                                            </td>

                                                            <td><h6><?= $evenement->nom_event ?></h6>
                                                                <small class="text-muted"><?php if(!empty($evenement->type_evenement)) echo $evenement->type_evenement->nom ?></small>
                                                            </td>
                                                            <td><small class="text-muted"><?= h($evenement->antenne->ville_principale) ?></small></td>
                                                            <td><small class="text-muted"><?= $clientType[$evenement->client->client_type]." : ".$evenement->client->nom ?></small></td>
                                                        </tr>
                                                        <?php }} ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="facture" role="tabpanel">
                    <div class="card-body">
                        <div class="profiletimeline0">
                            <?php if(!empty($user->factures)){ ?>
                            <div class="sl-item">
                                <!--<div class="sl-left">Factures &lt;!&ndash;<img src="../assets/images/users/1.jpg" alt="user" class="img-circle">&ndash;&gt; </div>-->
                                <div class="sl-right">
                                    <div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Titre</th>
                                                            <th>Projet</th>
                                                            <th>Etat</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(!empty($user->factures)){ ?>
                                                        <?php foreach ($user->factures as $facture){ ?>
                                                        <tr>
                                                            <td><?php if(!empty($facture->created)) echo ($facture->created->format('d/m/Y H:i')) ?></td>
                                                            <td><h6><?= $facture->titre ?></h6>
                                                                <small class="text-muted"><?= $this->Number->currency($facture->montant, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                                                            </td>
                                                            <td><?php if(!empty($facture->evenement))  echo $facture->evenement->nom_event ?></td>
                                                            <?php $etats = ['1'=>'warning', '2'=>'success', '3'=>'danger', '4'=>'info',  ]?>
                                                            <td><span class="label label-<?= $etats[$facture->etat_facture->id] ?>"><?= $facture->etat_facture->nom ?></span> </td>
                                                        </tr>
                                                        <?php }} ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <!--<a href="#" class="link"><?= $user->full_name ?></a>--> <!--<span class="sl-date">5 minutes ago</span>-->
                                        <!--<p>assign a new task <a href="#"> Design weblayout</a></p>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="../assets/images/big/img1.jpg" class="img-responsive radius"></div>
                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="../assets/images/big/img2.jpg" class="img-responsive radius"></div>
                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="../assets/images/big/img3.jpg" class="img-responsive radius"></div>
                                            <div class="col-lg-3 col-md-6 m-b-20"><img src="../assets/images/big/img4.jpg" class="img-responsive radius"></div>
                                        </div>
                                        <div class="like-comm"> <a href="javascript:void(0)" class="link m-r-10">2 comment</a> <a href="javascript:void(0)" class="link m-r-10"><i class="fa fa-heart text-danger"></i> 5 Love</a> </div>
                                    -->
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="settings" role="tabpanel">
                    <div class="card-body">
                        <form class="form-horizontal form-material">
                            <div class="form-group">
                                <label class="col-md-12">Full Name</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="example-email" id="example-email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password</label>
                                <div class="col-md-12">
                                    <input type="password" value="password" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Phone No</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="123 456 7890" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Message</label>
                                <div class="col-md-12">
                                    <textarea rows="5" class="form-control form-control-line"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Select Country</label>
                                <div class="col-sm-12">
                                    <select class="form-control form-control-line">
                                        <option>London</option>
                                        <option>India</option>
                                        <option>Usa</option>
                                        <option>Canada</option>
                                        <option>Thailand</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       <?php if(!empty($user->antenne)) { ?>
       <!--<div class="form-group row">
            <div class="hide">
                <label class="control-label">Adresse *</label>
                 <div id="infoPanel"><?php echo $this->Form->control('adresse',['label' => false,'class'=>'form-control controls','id'=>'searchTextField']);?></div>
                 <input id="info" type="text" size="50" value="" class="hide" />
            </div>
             <div class="col-md-12">
                   <div id="mapCanvas" style="width:auto; height:350px;"></div>
             </div>
       </div>-->
       <?php } ?>
     </div>

</div>


        <!--==== MODAL ENVOYE SMS -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="emailModalLabel">Envoye email</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
                <?php echo $this->Form->create(null, ['url'=>['controller'=>'Emails', 'action'=>'add'] ,'type' => 'post','role'=>'form']); ?>
                <div class="form-group0">
                    <!--<label for="" class="control-label">Email expediteur * :</label>-->
                    <input type="hidden" name="email_expediteur" value="<?= $user_connected['email'] ?>" class="form-control" readonly="readonly"/>

                    <input type="hidden" name="expediteurs[0][id]" value="<?= $user_connected['id'] ?>" class="form-control"/>
                    <input type="hidden" name="expediteurs[0][_joinData][is_expediteur]" value="<?= intval('1') ?>" class="form-control"/>
                    <input type="hidden" name="destinateurs[0][id]" value="<?= $user->id ?>" class="form-control"/>
                    <input type="hidden" name="destinateurs[0][_joinData][is_destinateur]" value="<?= intval('1') ?>" class="form-control"/>
                </div>
                <div class="form-group0">
                    <label for="" class="control-label">To : </label><?= $user->email ?>
                    <input type="hidden"  name="email_destinateur" value="<?= $user->email ?>" class="form-control" readonly="readonly"/>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Objet * :</label>
                    <input type="text"  name="objet" class="form-control" required="required"/>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Contenu * :</label>
                    <textarea class="form-control" name="contenu" id="message-text1" required="required"></textarea>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Envoyer</button>
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Annuler</button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
</div>

<!--==== MODAL ENVOYE SMS -->
<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="smsModalLabel">Envoye SMS</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <?php echo $this->Form->create(null, ['url'=>['controller'=>'Messageries', 'action'=>'add'] ,'type' => 'post','role'=>'form']); ?>
            <div class="form-group0">
                <!--<label for="" class="control-label">Email expediteur * :</label>
                <input type="email" name="email_expediteur" value="<?= $user_connected['email'] ?>" class="form-control" readonly="readonly"/>-->

                <input type="hidden" name="users[][id]" value="<?= $user->id ?>" class="form-control"/>
                <input type="hidden" name="destinateur" value="<?= $user->telephone_portable ?>" class="form-control"/>
                <input type="hidden" name="source" value="view"/>
            </div>
            <div class="form-group0">
                <label for="" class="control-label">To : </label><?= $user->telephone_portable ?>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Contenu * :</label>
                <textarea class="form-control" name="message" required="required"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Envoyer</button>
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Annuler</button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
</div>


