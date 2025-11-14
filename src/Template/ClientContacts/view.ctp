<?php

$titrePage = "Information contact" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Liste contact',
    ['controller' => 'ClientContacts', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="mt-4  nouveau-contact">

                    <div class="row">
                        <div class="col-md-12">
                                <h3 class="legend-fieldset-contact">Information générales</h3>
                                <div class="row">
                                    <label class="control-label col-md-4 m-t-10">Civilité</label>
                                    <div class="col-md-8"> 
                                        <?= @$civilite[$clientContact->civilite] ?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5 client-name">Prénom</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->prenom ? : '--' ?>
                                    </div>
                                </div>
                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5 client-name">Nom</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->nom ? : '--'?>
                                    </div>
                                </div>
                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5">Fonction </label>
                                    <div class="col-md-8">
                                        <?= $clientContact->position ? : '--' ?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5">Email</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->email ? : '--' ?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5">Tél</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->tel ? : '--'?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5">Mobile</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->telephone_2 ? : '--' ?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5">Fax</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->fax ? : '--' ?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5 client-mail">Site web</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->site_web ? : '--' ?>
                                    </div>
                                </div>

                                <div class="row row-contact">
                                    <label class="control-label col-md-4 m-t-5">Date de naissance</label>
                                    <div class="col-md-8">
                                        <?= $clientContact->date_naiss ? : '--'  ?>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="mt-4  nouveau-contact">

                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="legend-fieldset-contact">Social </h3>
                            <div class="row">
                                <label class="control-label col-md-4 m-t-5"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</label>
                                <div class="col-md-8">
                                    <?= $clientContact->twitter ? : '--'  ?>
                                </div>
                            </div>

                            <div class="row row-contact">
                                <label class="control-label col-md-4 m-t-5 client-name"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</label>
                                <div class="col-md-8">
                                    <?= $clientContact->facebook ? : '--'  ?>
                                </div>
                            </div>
                            <div class="row row-contact">
                                <label class="control-label col-md-4 m-t-5"><i class="fa fa-linkedin-square" aria-hidden="true"></i> LinkedIN </label>
                                <div class="col-md-8">
                                    <?= $clientContact->linkedin ? : '--'  ?>
                                </div>
                            </div>

                            <div class="row row-contact">
                                <label class="control-label col-md-4 m-t-5"><i class="fa fa-viadeo-square" aria-hidden="true"></i> Viadeo</label>
                                <div class="col-md-8">
                                    <?= $clientContact->viadeo ? : '--'  ?>
                                </div>
                            </div>
                            
                            <br>
                            <h3 class="legend-fieldset-contact">Note </h3>
                            <?= $clientContact->contact_note ? : '--'  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
