
<?php

$titrePage = "Réglages" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row reglages">
    <!-- Column -->

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Bornes</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Couleur', ['controller' => 'Couleurs', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Gammes', ['controller' => 'GammesBornes', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Modèle de borne', ['controller' => 'ModelBornes', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Etat de borne', ['controller' => 'EtatBornes', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Catégories tickets', ['controller' => 'CategorieActus', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Accessoires', ['controller' => 'Accessoires', 'action' => 'index'] ); ?></li>
                </ul>
            </div>

            <div class="card-body">
                <h2>Equipements</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Liste des équipements', ['controller' => 'Equipements', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Type équipements', ['controller' => 'TypeEquipements', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Marque équipements', ['controller' => 'MarqueEquipements', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Matériaux', ['controller' => 'Materiels', 'action' => 'index'], ['escape'=>false] ); ?> </li>
                </ul>
            </div>

            <div class="card-body">
                <h2>Consommables</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Liste des types de consommables', ['controller' => 'TypeConsommables', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Commandes en cours', ['controller' => 'BonsCommandes', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Bons de livraison', ['controller' => 'BonsLivraisons', 'action' => 'index'] ); ?></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <!--<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <h2>Licences</h2>
                            <ul class="list-style-none">
                                <li class="mt-2"><?= $this->Html->link( 'Licences', ['controller' => 'Licences', 'action' => 'index'] ); ?></li>
                                <li class="mt-2"><?= $this->Html->link( 'Types licences', ['controller' => 'TypeLicences', 'action' => 'index'] ); ?></li>
                            </ul>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Utilisateurs</h2>
                        <ul class="list-style-none">
                            <li class="mt-2"><?= $this->Html->link( 'Types de contact', ['controller' => 'Status', 'action' => 'index'] ); ?></li>
                            <li class="mt-2"><?= $this->Html->link( 'Situations professionnelles', ['controller' => 'Situations', 'action' => 'index'] ); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="card">
            <div class="card-body">
                <h2>Licences</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Licences', ['controller' => 'Licences', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Types licences', ['controller' => 'TypeLicences', 'action' => 'index'] ); ?></li>
                </ul>
                <br>

                <h2>Utilisateurs</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Types de contact', ['controller' => 'Statuts', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Situations professionnelles', ['controller' => 'Situations', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Contacts', ['controller' => 'Users', 'action' => 'index', 1] ); ?> </li>
                    <li class="mt-2"><?= $this->Html->link( 'Utilisateurs Konitys', ['controller' => 'Users', 'action' => 'index', 2] ); ?> </li>
                    <li class="mt-2"><?= $this->Html->link( 'Envoi SMS', ['controller' => 'Messageries', 'action' => 'add'] ); ?> </li>
                </ul>
                <br>

                <h2>Clients</h2>
                <ul class="list-style-none">
                    <li class="mt-2"> <?= $this->Html->link('Tous les clients', ['controller' => 'Clients', 'action' => 'index'] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Groupe des clients', ['controller' => 'GroupeClients', 'action' => 'index'] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Types de contact', ['controller' => 'ContactTypes', 'action' => 'index'] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Factures', ['controller' => 'Documents', 'action' => 'index', '?'=>['typeDocument'=>'invoice']] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Devis', ['controller' => 'Documents', 'action' => 'index', '?'=>['typeDocument'=>'estimate']] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Stripes', ['controller' => 'StripeCsvFiles', 'action' => 'add'] ); ?> </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Fournisseurs</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Liste des fournisseurs', ['controller' => 'Fournisseurs', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Types fournisseurs', ['controller' => 'TypeFournisseurs', 'action' => 'index'] ); ?></li>
                </ul><br>

                <h2>Projets</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Options événements', ['controller' => 'OptionEvenements', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Type installations', ['controller' => 'TypeInstallations', 'action' => 'index'] ); ?></li>
                </ul><br>

                <h2>Factures</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Message type', ['controller' => 'MessageTypeFactures', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Factures fournisseurs', ['controller' => 'Factures', 'action' => 'fournisseurs'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Tableau de bord facturation', ['controller' => 'FactureDeductions', 'action' => 'index'] ); ?></li>
                </ul> <br>

                <h2>Doc</h2>
                <ul class="list-style-none">
                    <li class="mt-2"> <?= $this->Html->link('Catégories ', ['controller' => 'Categories', 'action' => 'index'] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Ajouter une documentation', ['controller' => 'Posts', 'action' => 'add'] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Toute la documentation', ['controller' => 'Posts', 'action' => 'index'] ); ?> </li>
                    <li class="mt-2"> <?= $this->Html->link('Documents commerciaux & marketing', ['controller' => 'DocumentMarketings', 'action' => 'index'] ); ?> </li>
                </ul>
                
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Antennes</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Type de lieu', ['controller' => 'LieuTypes', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Debits internet', ['controller' => 'DebitInternets', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Etat des antennes', ['controller' => 'Etats', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Pays', ['controller' => 'Payss', 'action' => 'index'] ); ?></li>
                </ul>
                
                <h2>Vue PipeLine</h2>
                <ul class="list-style-none">
                                    <li class="mt-2"><?= $this->Html->link( 'Pipes', ['controller' => 'Pipes', 'action' => 'index'] ); ?></li>
                                </ul>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Etapes', ['controller' => 'PipeEtapes', 'action' => 'index'] ); ?></li>
                </ul>

                <!-- Facture & devis -->
                <h2>Facture & devis</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link('Adresses', ['controller' => 'Adresses', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Tva', ['controller' => 'Tvas', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link("Secteurs d'activités", ['controller' => 'SecteursActivites', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Catégories', ['controller' => 'CatalogCategories', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Sous catégories', ['controller' => 'CatalogSousCategories', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Sous sous catégories', ['controller' => 'CatalogSousSousCategories', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Informations bancaires', ['controller' => 'InfosBancaires', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Unites', ['controller' => 'CatalogUnites', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Modèles d\'emails', ['controller' => 'ModelesMails', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Modèles devis', ['controller' => 'Devis', 'action' => 'model-list'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Modèles devis', ['controller' => 'Devis', 'action' => 'model-list'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Paramètres SMS auto', ['controller' => 'SmsAutos', 'action' => 'add', 1] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Catégories de modèles devis', ['controller' => 'ModeleDevisCategories', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Sous catégories de modèles devis', ['controller' => 'ModeleDevisSousCategories', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Paramètrage de préférences par défaut', ['controller' => 'devisPreferences', 'action' => 'add', 1] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Bas de page facture (pdf)', ['controller' => 'DevisFacturesFooter', 'action' => 'add', 1] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Types de documents', ['controller' => 'DevisTypeDocs', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link('Translation', ['controller' => 'Langues', 'action' => 'index'] ); ?></li>
                </ul>
            </div>
        </div>
    </div>
    
   

    <!--<div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Projets</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Options événements', ['controller' => 'OptionEvenements', 'action' => 'index'] ); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Utilisateurs</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Types de contact', ['controller' => 'Status', 'action' => 'index'] ); ?></li>
                    <li class="mt-2"><?= $this->Html->link( 'Situations professionnelles', ['controller' => 'Situations', 'action' => 'index'] ); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h2>Factures</h2>
                <ul class="list-style-none">
                    <li class="mt-2"><?= $this->Html->link( 'Message type', ['controller' => 'MessageTypefactures', 'action' => 'index'] ); ?></li>
                </ul>
            </div>
        </div>
    </div>-->


</div>
