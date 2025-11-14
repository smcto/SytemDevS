<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Client $client
*/
?>
<?= $this->Html->css('bootstrap/bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('Clients/edit.js', ['block' => true]); ?>
<?php
    $titrePage = "Modification du cient" ;
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
        );
    $this->Breadcrumbs->add(
        'Clients',
        ['controller' => 'Clients', 'action' => 'liste']
        );
    $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();

    $contact = count($client->client_contacts)?$client->client_contacts[0]:null;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-body">
                <?= $this->Form->create($client) ?>
                <div class="form-body">
                    <h3 class="card-title">Informations</h3>
                    <hr>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <?php echo $this->Form->control('nom',['label' => 'Enseigne *','type'=>'text']); ?>
                        </div>
                        <div class="col-md-3 hide">
                            <?php echo $this->Form->control('prenom',['label' => 'Prenom','type'=>'text',]); ?>
                        </div>
                        <div class="col-md-3 hide">
                            <input type="hidden" value="<?= $contact!=null?$contact->id:'' ?>" id="contact_id" name="contact_id">
                        </div>
                        <div class="col-md-3">
                            <label for="contact_nom" class="control-label">Nom du contact *</label>
                            <input type="text" value="<?= $contact!=null?$contact->nom:'' ?>" id="contact_nom" class="form-control" name="contact_nom" required="required" maxlength="255">
                        </div>
                        <div class="col-md-3">
                            <label for="contact_prenom" class="control-label">Prenom du contact *</label>
                            <input type="text" value="<?= $contact!=null?$contact->prenom:'' ?>" id="contact_prenom" class="form-control" name="contact_prenom" maxlength="255">
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Form->control('groupe_client_id',['label' => 'Groupe','options' => $groupeClients, 'empty' => 'Séléctionner']); ?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Form->control('adresse',['label' => 'Adresse','type'=>'text','id'=>'searchTextField']); ?>
                            <input id="info" type="text" size="50" value="" class="hide" />
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Form->control('cp',['label' => 'Code postal','type'=>'number']); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('ville',['label' => 'Ville','type'=>'text']); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('country',['label' => 'Pays','type'=>'text']); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('adresse_2',['label' => 'Adresse 2','type'=>'text']); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('telephone',['label' => 'Telephone', 'type'=>'text', 'value'=>$client->telephone != null ?$client->telephone:($contact!=null?$contact->tel:''), ]);
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('email',['label' => 'Email', 'type'=>'mail', 'value'=>$client->email != null ?$client->email:($contact!=null?$contact->email:''), ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Form->control('client_type',['label' => 'Type du client','options' => $type_clients, 'empty' => 'Séléctionner']); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('secteurs_activites._ids', ['required' => true, 'multiple'=> "multiple", 'class' => 'select2 secteurs_activites form-control', 'label' => "Secteur d'activité", 'style' => 'width:100%']); ?>
                        </div>
                    </div>
                    
                    <h3 class="card-title">Localisation Google Maps</h3>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label class="control-label">Latitude</label><?php echo $this->Form->control('addr_lat',["id"=>"txtLatitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true"]);?>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Longitude</label><?php echo $this->Form->control('addr_lng',["id"=>"txtLongitude", 'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true"]);?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="mapCanvas" style="width:auto; height:250px;"></div>
                            <div class="kl_infoForm">Vous pouvez déplacer la position du curseur s'il est mal positionné</div>
                            <div class="error error-message kl_erreurLongLat hide">Déplacer le cuseur pour prendre la position</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
</div>