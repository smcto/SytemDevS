<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->


<aside class="left-sidebar ">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav ml-auto">
            <ul id="sidebarnav" class="w-90 d-inline-block text-right">
                <li class="nav-small-cap">PERSONAL</li>
                <!--<li>
                   <?php
                    echo $this->Html->link(
                        '<i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard',
                        ['controller' => 'Dashboards', 'action' => 'index'],
                        ['escape' => false, "class"=>"has-arrow", "href"=>"#", "aria-expanded"=>"false"]
                    );
                    ?>

                </li>-->

                <li class="logo float-left">
                    <a href=""><?php echo $this->Html->image('Konitys-LOGO.png', ['alt' => 'Logo', "class"=>"light-logo", 'width' => '120px']); ?></a>
                </li>
                <li>
                    <?php echo $this->Html->link('<i class="mdi mdi-page-layout-body"></i><span class="hide-menu">Bornes</span>', ['controller' => 'Bornes', 'action' => 'index'],['class'=>"has-arrow", 'aria-expanded'=>"false",'escape' => false,"onclick"=>"window.location.href='".$this->Url->build(['controller' => 'Bornes', 'action' => 'index'])."'"]); ?>
                    <ul aria-expanded="false" class="collapse">
                        <li> <?= $this->Html->link('Location événementielle', ['controller' => 'Bornes', 'action' => 'index', 2] ); ?> </li>
                        <li> <?= $this->Html->link('Location financière', ['controller' => 'Bornes', 'action' => 'index', 4] ); ?> </li>
                        <li> <?= $this->Html->link('Location longue durée', ['controller' => 'Bornes', 'action' => 'index', 9] ); ?> </li>
                        <li> <?= $this->Html->link('Ventes', ['controller' => 'Bornes', 'action' => 'index', 1] ); ?> </li>
                        <li> <?= $this->Html->link('Stock tampon', ['controller' => 'Bornes', 'action' => 'index', 3] ); ?> </li>
                        <li> <?= $this->Html->link('SAV', ['controller' => 'Bornes', 'action' => 'index', 11] ); ?> </li>
                        <li> <?= $this->Html->link('Contats de location financière', ['controller' => 'Bornes', 'action' => 'index', 4, 1] ); ?> </li>
                        <li role="separator" class="dropdown-divider"></li>
                        <li> <?= $this->Html->link('Carte location', ['controller' => 'Bornes', 'action' => 'mapfullscreen'] ); ?> </li>
                        <li role="separator" class="dropdown-divider"></li>

                        <!--<li>
                            <?php
                                echo $this->Html->link(
                            'Catégories Ticket',
                            ['controller' => 'CategorieActus', 'action' => 'index']
                            );
                            ?>
                        </li>-->

                        <li>
                            <?php
                                echo $this->Html->link(
                            'Tickets Bornes',
                            ['controller' => 'ActuBornes', 'action' => 'index']
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                                echo $this->Html->link(
                            'Licences',
                            ['controller' => 'Licences', 'action' => 'index']
                            );
                            ?>
                        </li>

                        <!--<li>
                            <a class="has-arrow" href="#" aria-expanded="false">Licences</a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <?php
                                echo $this->Html->link(
                                    'Type de licence',
                                    ['controller' => 'TypeLicences', 'action' => 'index']
                                    );
                                    ?>
                                </li>

                                <li>
                                    <?php
                                echo $this->Html->link(
                                    'Licences',
                                    ['controller' => 'Licences', 'action' => 'index']
                                    );
                                    ?>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
                </li>
                <li>
                    <?php
                    // à modifier "Lot produits" par "Fournisseurs"
                    echo $this->Html->link('<i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Stock</span>', ['controller' => 'LotProduits', 'action' => 'index'], ['escape'=>false]);
                    ?>
                </li>
               <!--<li>
                    <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Fourniseurs</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <?php
                                    echo $this->Html->link(
                            'Type de fournisseur',
                            ['controller' => 'TypeFournisseurs', 'action' => 'index']
                            );
                            ?>
                        </li>
                        <li>
                        <?php
                                    echo $this->Html->link(
                        'Fournisseurs',
                        ['controller' => 'Fournisseurs', 'action' => 'index']
                        );
                        ?>
                        </li>

                    </ul>
                </li>-->

                <li class="nav-devider"></li>

                <li>
                    <?= $this->Html->link('<i class="mdi mdi-access-point-network"></i><span class="hide-menu">Antennes</span>',['controller' => 'Antennes', 'action' => 'index'], ['escape'=>false,"onclick"=>"window.location.href='".$this->Url->build(['controller' => 'Antennes', 'action' => 'index'])."'"]) ?>
                    <ul aria-expanded="false" class="collapse">
                        <li><?= $this->Html->link('Contacts',['controller' => 'Users', 'action' => 'index', 1]);?></li>
                    </ul>
                </li>
                <!--<li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-access-point-network"></i><span class="hide-menu">Antennes</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <?php
                                echo $this->Html->link(
                            'Type de lieu',
                            ['controller' => 'LieuTypes', 'action' => 'index']
                            );
                            ?>
                        </li>

                        <li>
                                <?php
                                echo $this->Html->link(
                                    'Débits internets',
                                    ['controller' => 'DebitInternets', 'action' => 'index']
                                );
                                ?>
                        </li>
                        <li>
                                <?php
                                echo $this->Html->link(
                                    'Etats des antennes',
                                    ['controller' => 'Etats', 'action' => 'index']
                                );
                                ?>
                        </li>
                        <li>
                                 <?php
                                    echo $this->Html->link(
                                    'Antennes',
                                    ['controller' => 'Antennes', 'action' => 'index']
                                    );
                                    ?>
                        </li>
                        <li>
                                    <?php
                                    echo $this->Html->link(
                                    'Pays',
                                    ['controller' => 'Payss', 'action' => 'index']
                                    );
                                    ?>
                        </li>
                    </ul>
                </li>-->


                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-camera-party-mode"></i><span class="hide-menu">Projets</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <!--<li>
                                    <?php
                                    echo $this->Html->link(
                                    'Options événements',
                                    ['controller' => 'OptionEvenements', 'action' => 'index']
                                    );
                                    ?>
                        </li>-->
                        <li>
                                    <?php
                                    echo $this->Html->link(
                                    'Evénements',
                                    ['controller' => 'Evenements', 'action' => 'index']
                                    );
                                    ?>
                        </li>
                        <li>
                            <?php
                                echo $this->Html->link(
                            'Agenda',
                            ['controller' => 'DateEvenements', 'action' => 'index']
                            );
                            ?>
                        </li>

                    </ul>
                </li>

                <li>
                    <?= $this->Html->link('<i class="mdi mdi-file-document-box"></i><span class="hide-menu">CRM</span>', ['controller' => 'DevisFactures', 'action' => 'board'], ['class'=> 'has-arrow', 'aria-expanded'=> 'false', 'escape' => false, "onclick"=>"window.location.href='".$this->Url->build(['controller' => 'DevisFactures', 'action' => 'board'])."'"] ); ?>
                    <ul aria-expanded="false" class="collapse">
                        <li> <?= $this->Html->link('Opportunités', ['controller' => 'Opportunites', 'action' => 'index'], []); ?> </li>
                        <li> <?= $this->Html->link('Pipelines', ['controller' => 'Opportunites', 'action' => 'pipeline'], []); ?> </li>
                        <li> <?= $this->Html->link('Devis', ['controller' => 'Devis', 'action' => 'index'], []); ?> </li>
                        <li> <?= $this->Html->link('Factures', ['controller' => 'DevisFactures', 'action' => 'index'], []); ?> </li>
                        <li> <?= $this->Html->link('Règlements', ['controller' => 'Reglements', 'action' => 'index'] ); ?></li>
                        <li> <?= $this->Html->link('Avoirs', ['controller' => 'Avoirs', 'action' => 'index'] ); ?></li>
                        <li> <?= $this->Html->link('Clients', ['controller' => 'Clients', 'action' => 'liste'], []); ?> </li>
                        <li> <?= $this->Html->link('Contact clients part', ['controller' => 'ClientContacts', 'action' => 'index', 'person'], []); ?> </li>
                        <li> <?= $this->Html->link('Contact clients pros', ['controller' => 'ClientContacts', 'action' => 'index', 'corporation'], []); ?> </li>
                        <li> <?= $this->Html->link('Produits', ['controller' => 'CatalogProduits', 'action' => 'index'] ); ?> </li>
                        <li role="separator" class="dropdown-divider"></li>
                        <li> <?= $this->Html->link('Factures antennes', ['controller' => 'Factures', 'action' => 'index'], []); ?> </li>
                    </ul>
                </li>


                <li>
                    <?php $ventesUrl = ['controller' => 'Ventes', 'action' => 'dashboard']; ?>
                    <?php $fullVentesUrl = $this->Url->build($ventesUrl); ?>
                    <?= $this->Html->link('<i class="mdi mdi-folder-upload"></i><span class="hide-menu">Logistique</span>', $ventesUrl, ['class'=> 'has-arrow', 'aria-expanded'=> 'false', 'onclick' => "window.location.href='$fullVentesUrl'", 'escape' => false] ); ?>
                    <ul aria-expanded="false" class="collapse">
                        <li> <?= $this->Html->link('Bornes', ['controller' => 'Ventes', 'action' => 'index'], []); ?> </li>
                        <li> <?= $this->Html->link('Consommables', ['controller' => 'VentesConsommables', 'action' => 'index'], []); ?> </li>
                        <li> <?= $this->Html->link('Facturations', ['controller' => 'Ventes', 'action' => 'facturations'], []); ?> </li>
                        <li> <?= $this->Html->link('Facturations consommables', ['controller' => 'VentesConsommables', 'action' => 'facturations'], []); ?> </li>
                    </ul>
                </li>

                <!--<li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-file-document-box"></i><span class="hide-menu">Factures</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                                    <?php
                                    echo $this->Html->link(
                                    'Message types ',
                                    ['controller' => 'MessageTypeFactures', 'action' => 'index']
                                    );
                                    ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                            'Factures',
                            ['controller' => 'Factures', 'action' => 'index']
                            );
                            ?>
                        </li>
                    </ul>
                </li>-->
                <!--<li>
                <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-checkbox-multiple-marked-circle"></i><span class="hide-menu">Licences</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">Type de licence </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <?php
                                echo $this->Html->link(
                                    'Ajouter un type de licence',
                                    ['controller' => 'TypeLicences', 'action' => 'add']
                                    );
                                    ?>
                                </li>

                                <li>
                                    <?php
                                echo $this->Html->link(
                                    'Liste des types de licence',
                                    ['controller' => 'TypeLicences', 'action' => 'index']
                                    );
                                    ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">Licences </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <?php
                                echo $this->Html->link(
                                    'Ajouter une licence',
                                    ['controller' => 'Licences', 'action' => 'add']
                                    );
                                    ?>
                                </li>
                                <li>
                                    <?php
                                echo $this->Html->link(
                                    'Liste des licences',
                                    ['controller' => 'Licences', 'action' => 'index']
                                    );
                                    ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>-->

            </ul>
            <ul class="w-10 d-inline-block float-right">
                <div class="topbar float-right">
                    <nav class="navbar top-navbar navbar-expand-md navbar-light ">
                        <div class="navbar-collapse"><?= $this->element('header_right') ?></div>
                    </nav>
                </div>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
