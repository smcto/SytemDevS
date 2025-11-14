<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light px-3">
        <div class="navbar-header w-100">
            
            <div class="row doc_header">
                <div class="col-md-6 my-auto">

                    <?php if (isset($vente_mode) && $vente_mode != 'edition' && !empty($this->fetch('vente_header_left'))): // mode view ?>
                        <h1 class="m-0 top-title"><?= $this->fetch('vente_header_left') ?></h1>
                    <?php elseif (isset($vente_mode) && $vente_mode == 'edition' && empty($this->fetch('vente_header_left')) && @$modemarker == null): // mode edition ?>
                        <h1 class="m-0 top-title">Edition fiche de vente # <?= $vente_id ?></h1>
                    <?php else: // mode création ?>
                        <?php if ($custom_title = $this->fetch('custom_title')): ?>
                            <h1 class="m-0 top-title"><?= $custom_title ?></h1>
                        <?php else: ?>
                            <h1 class="m-0 top-title"><?= $this->fetch('info_sup') ?></h1>
                        <?php endif ?>
                    <?php endif ?>

                </div>

                <div class="col-md-6 my-auto">
                    <?= $this->fetch('bloc_btn') ?>
                </div>
            </div>

        </div>
    </nav>
</header>