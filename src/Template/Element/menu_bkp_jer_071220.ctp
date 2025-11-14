<div class="inner-header-wrapper container-fluid">
    <a href="" class="logo-wrap">
        <?php echo $this->Html->image('Konitys-LOGO.png', ['alt' => 'logo'] ); ?>
    </a>
    <div class="main-header-right-section">
        <div class="nav-wrapper customized-scrollbar">
            <div class="nav-block">
                <?= $this->Html->link('<div class="text">Bornes</div>', ['controller' => 'Bornes', 'action' => 'index'], ['escape' => false, 'class' => 'main-nav-wrapper'] ); ?>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Location événementielle', ['controller' => 'Bornes', 'action' => 'index', 2], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Location financière', ['controller' => 'Bornes', 'action' => 'index', 4], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Location longue durée', ['controller' => 'Bornes', 'action' => 'index', 9], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Ventes', ['controller' => 'Bornes', 'action' => 'index', 1], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Stock tampon', ['controller' => 'Bornes', 'action' => 'index', 3], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('SAV', ['controller' => 'Bornes', 'action' => 'index', 11], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Contrats de location financière', ['controller' => 'Bornes', 'action' => 'index', 4, 1], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Carte location', ['controller' => 'Bornes', 'action' => 'mapfullscreen'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Catégories Ticket', ['controller' => 'CategorieActus', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Tickets Bornes', ['controller' => 'ActuBornes', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Licences', ['controller' => 'Licences', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>

            <div class="nav-block">
                <?= $this->Html->link('<div class="text">Stocks</div>', ['controller' => 'LotProduits', 'action' => 'index'], ['escape' => false, 'class' => 'main-nav-wrapper'] ); ?>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Stock composants', ['controller' => 'LotProduits', 'action' => 'index', 'stock-composants'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Stock event', ['controller' => 'LotProduits', 'action' => 'index', 'stock-event'], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>

            <div class="nav-block">
                <?= $this->Html->link('<div class="text">Antennes</div>', ['controller' => 'Antennes', 'action' => 'index'], ['escape' => false, 'class' => 'main-nav-wrapper'] ); ?>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Contacts', ['controller' => 'Users', 'action' => 'index', 1], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>
            <div class="nav-block">
                <div class="main-nav-wrapper">
                    <div class="text">Projets</div>
                </div>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Options événements', ['controller' => 'OptionEvenements', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Evénements', ['controller' => 'Evenements', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Agenda', ['controller' => 'DateEvenements', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>
            <div class="nav-block">
                <?= $this->Html->link('<div class="text">CRM</div>', ['controller' => 'DevisFactures', 'action' => 'board'], ['escape' => false, 'class' => 'main-nav-wrapper'] ); ?>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Opportunités', ['controller' => 'Opportunites', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Pipelines', ['controller' => 'Opportunites', 'action' => 'pipeline'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Devis', ['controller' => 'Devis', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Factures', ['controller' => 'DevisFactures', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Règlements', ['controller' => 'Reglements', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Avoirs', ['controller' => 'Avoirs', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Clients', ['controller' => 'Clients', 'action' => 'liste'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Contact clients part', ['controller' => 'ClientContacts', 'action' => 'index', 'person'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Contact clients pros', ['controller' => 'ClientContacts', 'action' => 'index', 'corporation'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Produits', ['controller' => 'CatalogProduits', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Factures antennes', ['controller' => 'Factures', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>
            <div class="nav-block">
                <?= $this->Html->link('<div class="text">Ventes</div>', ['controller' => 'Ventes', 'action' => 'dashboard'], ['escape' => false, 'class' => 'main-nav-wrapper'] ); ?>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Bornes', ['controller' => 'Ventes', 'action' => 'index'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Consommables', ['controller' => 'VentesConsommables', 'action' => 'pipeline'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Facturations', ['controller' => 'Ventes', 'action' => 'facturations'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Facturations consommables', ['controller' => 'VentesConsommables', 'action' => 'facturations'], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>
            <div class="nav-block">
                <div class="main-nav-wrapper">
                    <div class="text">Dashboards (beta)</div>
                </div>
                <div class="sub-nav-wrapper customized-scrollbar">
                    <?= $this->Html->link('Règlements en retard', ['controller' => 'DevisFactures', 'action' => 'dashboardReglementsRetard'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Encaissements', ['controller' => 'Reglements', 'action' => 'dashboardEncaissements'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link("Chiffre d'affaires Annuel", ['controller' => 'Reglements', 'action' => 'dashboardCAAnnuel'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Commercial', ['controller' => 'Reglements', 'action' => 'dashboardCommercial'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Ventes Consommables', ['controller' => 'VentesConsommables', 'action' => 'dashboard'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Synthèse mensuelle', ['controller' => 'DevisFactures', 'action' => 'dashboardSyntheseMensuelle'], ['class' => 'sub-nav-block'] ); ?>
                    <?= $this->Html->link('Clients', ['controller' => 'Clients', 'action' => 'dashboard'], ['class' => 'sub-nav-block'] ); ?>
                </div>
            </div>
        </div>
        <div class="header-search-wrapper">
            <div class="header-search-wrap">
                <svg class="magnifying-glass-icon" viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>
                <input type="text" placeholder="Rechercher" class="header-input-search" />
            </div>

            <div class="sub-nav-wrapper animate__animated">
                <div class="search-zone-wrapper">
                    <div class="instruction">
                        Zone(s) de recherche *
                    </div>
                    <div class="inner-search-zone-wrapper customized-scrollbar">
                        <div class="zone-block">
                            <div class="checkbox-wrap">
                                <input type="checkbox">
                                <svg viewBox="0 -46 417.813 417"><path d="M159.988 318.582c-3.988 4.012-9.43 6.25-15.082 6.25s-11.094-2.238-15.082-6.25L9.375 198.113c-12.5-12.5-12.5-32.77 0-45.246l15.082-15.086c12.504-12.5 32.75-12.5 45.25 0l75.2 75.203L348.104 9.781c12.504-12.5 32.77-12.5 45.25 0l15.082 15.086c12.5 12.5 12.5 32.766 0 45.246zm0 0"></path></svg>
                            </div>
                            <div class="text">
                                Clients
                            </div>
                        </div>
                        <div class="zone-block">
                            <div class="checkbox-wrap">
                                <input type="checkbox">
                                <svg viewBox="0 -46 417.813 417"><path d="M159.988 318.582c-3.988 4.012-9.43 6.25-15.082 6.25s-11.094-2.238-15.082-6.25L9.375 198.113c-12.5-12.5-12.5-32.77 0-45.246l15.082-15.086c12.504-12.5 32.75-12.5 45.25 0l75.2 75.203L348.104 9.781c12.504-12.5 32.77-12.5 45.25 0l15.082 15.086c12.5 12.5 12.5 32.766 0 45.246zm0 0"></path></svg>
                            </div>
                            <div class="text">
                                Bornes
                            </div>
                        </div>
                        <div class="zone-block">
                            <div class="checkbox-wrap">
                                <input type="checkbox">
                                <svg viewBox="0 -46 417.813 417"><path d="M159.988 318.582c-3.988 4.012-9.43 6.25-15.082 6.25s-11.094-2.238-15.082-6.25L9.375 198.113c-12.5-12.5-12.5-32.77 0-45.246l15.082-15.086c12.504-12.5 32.75-12.5 45.25 0l75.2 75.203L348.104 9.781c12.504-12.5 32.77-12.5 45.25 0l15.082 15.086c12.5 12.5 12.5 32.766 0 45.246zm0 0"></path></svg>
                            </div>
                            <div class="text">
                                Devis
                            </div>
                        </div>
                        <div class="zone-block">
                            <div class="checkbox-wrap">
                                <input type="checkbox">
                                <svg viewBox="0 -46 417.813 417"><path d="M159.988 318.582c-3.988 4.012-9.43 6.25-15.082 6.25s-11.094-2.238-15.082-6.25L9.375 198.113c-12.5-12.5-12.5-32.77 0-45.246l15.082-15.086c12.504-12.5 32.75-12.5 45.25 0l75.2 75.203L348.104 9.781c12.504-12.5 32.77-12.5 45.25 0l15.082 15.086c12.5 12.5 12.5 32.766 0 45.246zm0 0"></path></svg>
                            </div>
                            <div class="text">
                                Factures
                            </div>
                        </div>
                    </div>
                    <div class="search-button-wrapper">
                        <div class="search-button" id="btn-header-search">
                            Rechercher
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?= $this->element('header_right') ?>

    </div>

    <div class="burger-menu-wrap">
        <div></div>
    </div>

</div>
