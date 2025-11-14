<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
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
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="mdi mdi-page-layout-body"></i><span class="hide-menu">Factures</span></a>
                    <ul aria-expanded="false" class="collapse">

                                <li>
                                    <?php echo $this->Html->link(
                                    'Ajouter une facture',
                                    ['controller' => 'Factures', 'action' => 'add']
                                    );
                                    ?>
                                </li>

                                <li>
                                    <?php echo $this->Html->link(
                                    'Liste des factures',
                                    ['controller' => 'Factures', 'action' => 'index']
                                    );
                                    ?>
                                </li>
                    </ul>
                </li>
                <li>
                    <?php
                                echo $this->Html->link(
                    'Documentations',
                    ['controller' => 'Posts', 'action' => 'index']
                    );
                    ?>
                </li>

                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class=""></i><span class="hide-menu"></span></a>
                    <!--<ul aria-expanded="false" class="collapse">
                        <li>
                            <?php /*echo $this->Html->link(
                            'Ajouter un matériel',
                            ['controller' => 'Materiels', 'action' => 'add']
                            );*/
                            ?>
                        </li>

                        <li>
                            <?php /*echo $this->Html->link(
                            'Liste des matériels',
                            ['controller' => 'Materiels', 'action' => 'index']
                            );*/
                            ?>
                        </li>
                    </ul>-->
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
