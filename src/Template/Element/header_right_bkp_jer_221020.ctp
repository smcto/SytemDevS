<ul class="navbar-nav my-lg-0">
    <!--<li class="nav-item hidden-sm-down">
        <form class="app-search">
            <input type="text" class="form-control" placeholder="Search for..."> <a class="srh-btn"><i class="ti-search"></i></a>
        </form>
    </li>-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $this->Html->image($user_connected['url_photo'], ['alt' => 'User',"class"=>"profile-pic"]); ?> </a>
        <div class="dropdown-menu dropdown-menu-right animated flipInY">
            <ul class="dropdown-user">
                <li>
                    <div class="dw-user-box">
                        <div class="u-img"><?php echo $this->Html->image($user_connected['url_photo'], ['alt' => 'User']); ?></div>
                        <div class="u-text">
                            <h4><?= $user_connected['full_name'] ?><!--Steave Jobs--></h4>
                            <p class="text-muted"><?= $user_connected['email'] ?><!--varun@gmail.com--></p>
                            <?php $userUrl = $ventesUrl = ['controller' => 'Users', 'action' => 'edit', $user_connected['id']]; ?>
                            <a href="<?= $this->Url->build($userUrl) ?>" class="">Mon compte</a>
                        </div>
                    </div>
                </li>
                <li role="separator" class="divider"></li>
                <!--<li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                <li role="separator" class="divider"></li>-->
                <!--<li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>-->
                <li>
                    <?= $this->Html->link('<i class="fa fa-power-off"></i> Logout',['controller'=>'Users','action'=>'logout'] ,['escapeTitle'=> false,'class'=>'']) ?>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item dropdown">
        <?php
            //$link =  $this->Html->link('<i class="flag-icon flag-icon-us"></i> English',['lang' => 'en'], ['escapeTitle'=> false]);
            //$code = 'fr';
            if($this->request->getParam('lang') == 'fr'){
                //echo 'iciiiiii';
                $code = 'fr';
                $link =  $this->Html->link('<i class="flag-icon flag-icon-us"></i> English',['lang'=>'en'], ['escapeTitle'=> false,'class'=>'dropdown-item']);

            }else if($this->request->getParam('lang') == 'en'){
                //echo 'lllll';
                $code = 'us';
                $link =  $this->Html->link('<i class="flag-icon flag-icon-fr"></i> Français',['lang' => 'fr'], ['escapeTitle'=> false,'class'=>'dropdown-item']);
            }
            ?>
        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-<?= @$code; ?>"></i></a>
        <div class="dropdown-menu  dropdown-menu-right animated bounceInDown">

             <?= $link ?>
           <!-- <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a>
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a>
            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> -->
        </div>
    </li>
    <?php if(!empty($user_connected['typeprofils']) ) { ?>
        <?php if(in_array('admin', $user_connected['typeprofils'])) { ?>
        <li class="nav-item">
            <?php
                    echo $this->Html->link(
            '<i class="mdi mdi-view-grid"></i>',
            ['controller' => 'Dashboards', 'action' => 'reglages'], ['class'=>'nav-link', 'escape'=>false]
            );
            ?>
        </li>
    <?php }} ?>
</ul>
