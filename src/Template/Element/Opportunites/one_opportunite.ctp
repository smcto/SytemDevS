<div class="card card-kanban crm_oneOpportunite" id="id_oppCaban_<?= $opportunite->id ?>" data-page="<?= $page ?>" data-opp="<?= $opportunite->id ?>">
    <div class="card-body">

        <div class="card-options">

            <div class="toggle-option-block">

                <i class="material-icons">more_vert</i>

            </div>

        </div>

        <div class="card-title" id="id_opportunite_<?= $opportunite->id ?>" data-opp="<?= $opportunite->id ?>">
            <a href="#" data-toggle="modal" data-target="#task-modal">
                <h6 id="opportunite_nom_<?= $opportunite->id ?>"><?= $opportunite->nom ?></h6>
            </a>

            <div id="id_opp_statut_<?= $opportunite->id ?>" class="status-icon <?= $opportunite->opportunite_statut->indent ?>"></div>

        </div>

        <div class="client-info-wrapper">

            <div class="client-type-block">
                <div class="type">P</div>
            </div>

            <div class="client-company-name">
                <?= @$opportunite->client->full_name ?>
            </div>

        </div>

        <div class="event-city-wrap">
            <h6><?= $opportunite->antenne_retrait ?></h6>
        </div>

        <div class="bottom-detail-wrapper">

            <div class="left-section">

                <div id="opportunite_montant_potentiel_<?= $opportunite->id ?>" class="amount"><?= $opportunite->montant_potentiel ? $this->Number->currency($opportunite->montant_potentiel) : '0 €' ?> </div>

                <div class="icon-with-quantity-wrap card-document-icon-wrap">

                    <svg viewBox="0 0 512.001 512.001"><path d="M447.229 67.855h-43.181v-43.18C404.049 11.103 392.944 0 379.379 0H64.771C51.2 0 40.097 11.103 40.097 24.675V419.47c0 13.571 11.103 24.675 24.675 24.675h43.181v43.181c0 13.571 11.098 24.675 24.675 24.675h209.729c13.565 0 32.762-7.612 42.638-16.908l68.929-64.882c9.888-9.296 17.969-28.012 17.969-41.583l.012-296.096c-.001-13.573-11.105-24.677-24.676-24.677zM107.951 92.531v333.108h-43.18c-3.343 0-6.168-2.825-6.168-6.168V24.675c0-3.343 2.825-6.168 6.168-6.168H379.38c3.337 0 6.168 2.825 6.168 6.168v43.181H132.626c-13.577 0-24.675 11.103-24.675 24.675zM441.24 416.737l-68.929 64.877c-1.412 1.327-3.251 2.628-5.281 3.867v-56.758c0-4.238 1.709-8.051 4.528-10.888 2.844-2.819 6.656-4.533 10.894-4.533h61.718c-.957 1.3-1.937 2.497-2.93 3.435zm12.145-28.111c0 1.832-.334 3.954-.839 6.168h-70.095c-18.721.037-33.89 15.206-33.928 33.928v64.024c-2.202.445-4.324.746-6.168.746H132.626v.001c-3.35 0-6.168-2.825-6.168-6.168V92.53c0-3.343 2.819-6.168 6.168-6.168h314.602c3.343 0 6.168 2.825 6.168 6.168l-.011 296.096z"/><path d="M379.379 154.216H200.488a9.248 9.248 0 00-9.253 9.253 9.249 9.249 0 009.253 9.253h178.891c5.108 0 9.253-4.139 9.253-9.253s-4.145-9.253-9.253-9.253zM379.379 277.59H200.488a9.248 9.248 0 00-9.253 9.253 9.249 9.249 0 009.253 9.253h178.891a9.252 9.252 0 009.253-9.253 9.251 9.251 0 00-9.253-9.253zM299.187 339.277h-98.698c-5.114 0-9.253 4.139-9.253 9.253s4.139 9.253 9.253 9.253h98.698c5.108 0 9.247-4.139 9.247-9.253s-4.139-9.253-9.247-9.253zM379.379 215.903H200.488c-5.114 0-9.253 4.139-9.253 9.253s4.14 9.253 9.253 9.253h178.891c5.108 0 9.253-4.139 9.253-9.253s-4.145-9.253-9.253-9.253z"/></svg>

                    <div class="number"><?= count($opportunite->linked_docs) ?></div>

                </div>

                <div class="icon-with-quantity-wrap card-comment-icon-wrap">

                    <svg viewBox="-21 -47 682.667 682"><path d="M552.012-1.332H87.988C39.473-1.332 0 38.133 0 86.656V370.63c0 48.414 39.3 87.816 87.676 87.988V587.48l185.191-128.863h279.145c48.515 0 87.988-39.472 87.988-87.988V86.656c0-48.523-39.473-87.988-87.988-87.988zm50.488 371.96c0 27.837-22.648 50.49-50.488 50.49h-290.91l-135.926 94.585v-94.586H87.988c-27.84 0-50.488-22.652-50.488-50.488V86.656c0-27.843 22.648-50.488 50.488-50.488h464.024c27.84 0 50.488 22.645 50.488 50.488zm0 0"/><path d="M171.293 131.172h297.414v37.5H171.293zm0 0M171.293 211.172h297.414v37.5H171.293zm0 0M171.293 291.172h297.414v37.5H171.293zm0 0"/></svg>

                    <div class="number">
                        <?= count($opportunite->opportunite_commentaires) ?>
                    </div>

                </div>

            </div>

            <div class="right-section">
                <div class="date">
                    <?= !empty($opportunite->created) ? $opportunite->created->format('d/m') :'' ?>
                </div>
            </div>

        </div>

    </div>
</div>
