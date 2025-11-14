<div class="header-avatar-wrapper">
    <div class="inner-header-avatar-wrapper">
        <div class="outer-avatar-wrap waves-effect">
            <div class="avatar-wrap online">
                <?php echo $this->Html->image($user_connected['url_photo'], ['alt' => 'User']); ?>
            </div>
        </div>
        <div class="sub-nav-wrapper animate__animated">
            <div class="header-user-detail-wrapper">
                <div class="left-section">
                    <?php echo $this->Html->image($user_connected['url_photo'], ['alt' => 'User']); ?>
                </div>
                <div class="right-section">
                    <div class="username">
                        <?= $user_connected['full_name'] ?>
                    </div>
                    <div class="user-email-address">
                        <?= $user_connected['email'] ?>
                    </div>
                    <div class="account-button-wrap">
                        <?php $userUrl = $ventesUrl = ['controller' => 'Users', 'action' => 'edit', $user_connected['id']]; ?>
                        <a href="<?= $this->Url->build($userUrl) ?>">Mon compte</a>
                    </div>
                </div>
            </div>
            <!--<a href="/fr/logout" class="sub-nav-block">
                <i class="fa fa-power-off"></i>
                <div class="text">Se déconnecter</div>
            </a>-->
            <?= $this->Html->link('<i class="fa fa-power-off"></i> Se déconnecter',['controller' => 'Users', 'action' => 'logout'],['escapeTitle' => false, 'class' => 'sub-nav-block']); ?>
        </div>
    </div>
</div>

<?php if(!empty($user_connected['typeprofils']) ): ?>
    <?php if(in_array('admin', $user_connected['typeprofils'])): ?>
        <div class="header-settings-wrapper">

            <!--<a href="#" class="inner-header-settings-wrap waves-effect">
                <svg class="header-settings-icon" viewBox="0 0 270 270"><path d="M114 0H10C4.5 0 0 4.5 0 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V10c0-5.5-4.5-10-10-10zm-10 104H20V20h84v84zM260 0H156c-5.5 0-10 4.5-10 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V10c0-5.5-4.5-10-10-10zm-10 104h-84V20h84v84zM114 146H10c-5.5 0-10 4.5-10 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V156c0-5.5-4.5-10-10-10zm-10 104H20v-84h84v84zM260 146H156c-5.5 0-10 4.5-10 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V156c0-5.5-4.5-10-10-10zm-10 104h-84v-84h84v84z"/></svg>

            </a>-->

            <?= $this->Html->link('<svg class="header-settings-icon" viewBox="0 0 270 270"><path d="M114 0H10C4.5 0 0 4.5 0 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V10c0-5.5-4.5-10-10-10zm-10 104H20V20h84v84zM260 0H156c-5.5 0-10 4.5-10 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V10c0-5.5-4.5-10-10-10zm-10 104h-84V20h84v84zM114 146H10c-5.5 0-10 4.5-10 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V156c0-5.5-4.5-10-10-10zm-10 104H20v-84h84v84zM260 146H156c-5.5 0-10 4.5-10 10v104c0 5.5 4.5 10 10 10h104c5.5 0 10-4.5 10-10V156c0-5.5-4.5-10-10-10zm-10 104h-84v-84h84v84z"/></svg><div class="text">Réglages</div>', ['controller' => 'Dashboards', 'action' => 'reglages'], ['class'=>'inner-header-settings-wrap waves-effect', 'escape'=>false] ); ?>

        </div>
    <?php endif; ?>
<?php endif; ?>
