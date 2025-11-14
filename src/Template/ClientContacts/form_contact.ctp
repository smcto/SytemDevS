<div class="mt-4  nouveau-contact">

    <h3 class="pb-2 mb-3 bordered">Informations contact</h3>

    <div class="row">
        <div class="col-md-6">
            <fieldset class="fieldset-contact">
                <legend class="legend-fieldset-contact">Information générales:</legend>
                <div class="row">
                    <label class="control-label col-md-4 m-t-10">Civilité</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('civilite', [
                                    'options' => $civilite, 
                                    'type' => 'radio', 
                                    'label'=>false,
                                    'hiddenField'=>false,
                                    'legend'=>false,
                                    'class' => 'row',
                                    'templates' => [
                                        'inputContainer' => '<div class="form-group row">{{content}}</div>',
                                        'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}} class="label-civilite">{{text}}</label>',
                                        'radioWrapper' => '<div class="radio radio-success radio-inline  m-l-15">{{label}}</div>'
                                    ]
                            ]) ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5 ">Prénom</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('prenom', ['label' => false]); ?>
                    </div>
                </div>
                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5 ">Nom</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('nom', ['label' => false]); ?>
                    </div>
                </div>
                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5">Fonction </label>
                    <div class="col-md-8">
                        <?= $this->Form->control('position', ['label' => false, 'id' => 'position_id']); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5">Email</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('email', ['class' => 'form-control','label' => false, 'maxlength' => 255]); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5">Tél</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('tel', ['type'=>'text', 'class' => 'form-control', 'label' => false , 'maxlength' => 255]); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5">Mobile</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('telephone_2', ['type'=>'text', 'class' => 'form-control', 'label' => false , 'maxlength' => 255]); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5">Fax</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('fax', ['class' => 'form-control','label' => false ]); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5 client-mail">Site web</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('site_web', ['class' => 'form-control','label' => false ]); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5">Date de naissance</label>
                    <div class="col-md-8">
                        <?= $this->Form->text('date_naiss', ['type' => 'date', 'class' => 'form-control pro','label' => false, 'id' => 'date_naiss']); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="fieldset-contact">
                <legend class="legend-fieldset-contact">Social :</legend>
                <div class="row">
                    <label class="control-label col-md-4 m-t-5"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('twitter', ['id' => 'twitter','label' => false]) ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5 "><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('facebook', ['label' => false]); ?>
                    </div>
                </div>
                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5"><i class="fa fa-linkedin-square" aria-hidden="true"></i> LinkedIN </label>
                    <div class="col-md-8">
                        <?= $this->Form->control('linkedin', ['label' => false]); ?>
                    </div>
                </div>

                <div class="row row-contact">
                    <label class="control-label col-md-4 m-t-5"><i class="fa fa-viadeo-square" aria-hidden="true"></i> Viadeo</label>
                    <div class="col-md-8">
                        <?= $this->Form->control('viadeo', ['class' => 'form-control','label' => false]); ?>
                    </div>
                </div>
            </fieldset>

            <fieldset class="fieldset-contact">
                <legend class="legend-fieldset-contact">Note :</legend>
                <?= $this->Form->control('contact_note', ['type'=>'textarea', 'class' => 'tinymce-note', 'label' => false]); ?>
            </fieldset>
        </div>
    </div>
</div>