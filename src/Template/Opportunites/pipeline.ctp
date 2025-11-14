<!--<div class="layout layout-nav-side">-->
<div class="main-container">

    <div class="pipeline-header-container">

        <div class="pipeline-related-tab-wrapper">

            <div class="pipeline-name">
                <?= $currentPipe->name ?>
            </div>

        </div>

        <div class="pipeline-menu-container">

            <div class="inner-pipeline-menu-container">

                <div class="pipeline-option-wrapper">

                    <div class="pipeline-option current">
                        Pipeline
                    </div>

                    <div class="pipeline-option">
                        Tâches
                    </div>

                </div>

                <div class="total-opportunity-wrap">
                    <?= $this->Number->format($countOpp,['locale' => 'fr_FR']) ?><?= $countOpp > 1 ? ' opportunités' : 'opportunité' ?> - <?= $this->Number->format($countOppHot,['locale' => 'fr_FR']) ?> hot
                </div>

                <div class="pipeline-top-right-option">

                    <div class="pipeline-selection-wrap">

                        <div class="customized-select">

                            <div class="selected-value-block">

                                <div class="select-icon-wrap">
                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                </div>
                                <div class="text value" option-id="<?= $currentPipe->id ?>"><?= $currentPipe->nom ?></div>

                            </div>

                            <div class="outer-option-list-wrap">

                                <div class="option-list-wrap">

                                    <div class="search-option-wrap">

                                        <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                        <input type="text" placeholder="Rechercher ..." />

                                    </div>
                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                        <?php 
                                        foreach($pipelines as $pipeline){ 
                                            $class = $pipeline->id == $idPipe ? 'option-block value selected ' : 'option-block value' ;
                                            echo $this->Html->link($pipeline->nom,['action'=>'pipeline',$pipeline->id],['class' =>$class, 'option-id' =>$pipeline->id]);
                                        } 
                                        ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?= $this->Html->link('Quitter',['action'=>'index'],["class"=>"leave-button"]) ?>

                    <div class="btn-late-payment-popup">
                        Popup
                    </div>

                </div>

            </div>

        </div>

        <div class="burger-menu-wrap">
            <div></div>
        </div>

    </div>

    <div class="container-kanban">

        <!--<div class="kanban-board container-fluid mt-lg-3">-->

        <div class="kanban-board customized-scrollbar">

            <?php foreach($allEtapes as $etape){ ?>
            <div class="kanban-col" data-etape="<?= $etape['etape']->id ?>" id="id_oneEtape_<?= $etape['etape']->id ?>">
                <div class="card-list">
                    <div class="card-list-header">

                        <div class="pipeline-card-title">
                            <h6><?= $etape['etape']->nom ?></h6>
                            <div id="id_countEtape_<?= $etape['etape']->id  ?>" class="number-of-quotes"><?=  $this->Number->format($etape['count'] ,['locale' => 'fr_FR']) ?></div>
                        </div>

                        <div class="dropdown">
                            <button class="btn-options" type="button" id="cardlist-dropdown-button-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item text-danger" href="#">Archive List</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-list-body customized-scrollbar crm_oneListeEtape" data-etape="<?= $etape['etape']->id ?>" id="id_cardListEtape_<?= $etape['etape']->id ?>"  data-nbrpage="<?= $etape['nbr_page'] ?>">
                        <?php
                        if(!empty($etape["opportunites"])){
                            foreach ($etape["opportunites"] as $key => $opportunite) {
                                echo $this->element('Opportunites/one_opportunite',['opportunite'=>$opportunite,'page'=>$etape['page']]); 
                            }
                        }
                        ?>
                    </div>

                    <div class=" crm_oneFooterEtape card-list-footer " id="id_etapeFooter_<?= $etape['etape']->id ?>">
                        <!--<button class="btn btn-link btn-sm text-small">Add task</button>-->
                    </div>

                </div>
            </div>
            <?php } ?>
            <!-- <div class="kanban-col">
                <div class="card-list">
                    <button class="btn btn-link btn-sm text-small">Add list</button>
                </div>
            </div> -->
        </div>
    </div>


    <!-- === Pipeline Loader Container === -->
    <div class="pipeline-large-loader-container">
        <div class="loading-spinner"></div>
    </div>
    <!-- === End of Pipeline Loader Container === -->


    <!-- === Pipe Popup Container === -->
    <div class="popup-container pipe-popup-container"></div>
    <!-- === End of Pipe Popup Container === -->



    <!-- === Late Popup Container === -->

    <div class="popup-container late-payment-popup-container">

        <div class="outer-popup-container">

            <div class="popup-close-wrap">

                <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

            </div>

            <div class="inner-popup-container customized-scrollbar white-background-scrollbar">

                <div class="top-header-wrapper">

                    <div class="left-section">

                        <div class="client-name">
                            Champagne Canard Duchene
                        </div>

                        <div class="quotation-wrapper">
                            <div class="quotation-name-wrap">
                                <div class="quotation-name">Facture FK-202009-03799</div>
                            </div>
                            <?php echo $this->Html->image('reglements-en-retard/avatar.jpg', ["class"=>"employee-avatar", "alt" => "avatar"]); ?>
                            <div class="payment-status-wrap">
                                <div class="status"></div>
                                <div class="status-type">Paiement partiel</div>
                            </div>
                        </div>

                        <div class="product-name-wrap">
                            <svg viewBox="0 0 451.846 451.847"><path d="M345.441 248.292L151.154 442.573c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744L278.318 225.92 106.409 54.017c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.287 194.284c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373z"/></svg>
                            <div class="name">
                                Consommables pour imprimantes DNP DS620
                            </div>
                        </div>

                    </div>

                    <div class="right-section">

                        <div class="date-wrapper">
                            <div class="date-wrap">
                                <div class="label">Date facture :</div>
                                <div class="value">30/09/20</div>
                            </div>
                            <div class="date-wrap">
                                <div class="label">Date échéance :</div>
                                <div class="value">30/10/20</div>
                            </div>
                            <div class="date-wrap">
                                <div class="label">Depuis création :</div>
                                <div class="value">50 jours</div>
                            </div>
                            <div class="date-wrap">
                                <div class="label">Retard échéance :</div>
                                <div class="value">20 jours</div>
                            </div>
                        </div>

                        <div class="amount-wrapper">
                            <div class="amount-wrap total-wrap">
                                <div class="top-label">Total facture</div>
                                <div class="ttc-amount">400 &euro; TTC</div>
                                <div class="ht-amount">360 &euro; HT</div>
                            </div>
                            <div class="amount-wrap remaining-wrap">
                                <div class="top-label">Restant dû</div>
                                <div class="ttc-amount">200 &euro; TTC</div>
                                <div class="ht-amount">160 &euro; HT</div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="middle-header-wrapper">

                    <div class="step-wrapper">
                        <div class="step-block current">
                            En retard
                        </div>
                        <div class="step-block">
                            Relance 1
                        </div>
                        <div class="step-block">
                            Relance 2
                        </div>
                        <div class="step-block">
                            Relance 3
                        </div>
                        <div class="step-block">
                            LR
                        </div>
                        <div class="step-block">
                            Injonction
                        </div>
                    </div>

                    <div class="issue-detail-wrapper">

                        <!--<div class="edit-icon-wrap">
                            <svg viewBox="0 0 24 24">
                                <path d="M2.43 15.67L16.118 1.972a.749.749 0 01.531-.222h.001c.199 0 .39.079.53.22l4.85 4.85a.75.75 0 010 1.061l-13.7 13.69zM22.568 5.943l.493-.493A3.168 3.168 0 0024 3.2c0-.864-.336-1.668-.937-2.258C21.861-.272 19.748-.271 18.549.94l-.493.493zM2.024 16.678l-1.99 6.348a.749.749 0 00.941.94l6.347-1.99zM6.97 8.788a.744.744 0 00.53-.22l4.842-4.842c.259-.258.605-.36.944-.335l1.184-1.185a2.705 2.705 0 00-3.189.459L6.439 7.507a.75.75 0 00.531 1.281z"/>
                            </svg>
                        </div>-->

                        <!--<div class="issue-type">
                            Événement mal passé, client pas content.
                        </div>
                        <div class="next-payment-date">
                            Prochaine échéance : règlement prévu le 2 octobre
                        </div>-->

                        <!--<div class="editable-block issue-type">
                            <input type="text" class="editable-text" value="Événement mal passé, client pas content." />
                        </div>

                        <div class="next-payment-wrapper">
                            <div class="label">
                                Prochaine échéance :
                            </div>
                            <div class="editable-block">
                                <input type="text" class="editable-text" value="règlement prévu le 2 octobre" />
                            </div>

                        </div>-->

                        <div class="editable-block issue-type">
                            <textarea class="editable-text">
                                <?php
                                echo "Événement mal passé, client pas content.\r\nProchaine échéance : règlement prévu le 2 octobre";
                                ?>
                            </textarea>
                        </div>

                    </div>

                </div>

                <div class="tab-wrapper client-event-tab-section">
                    <div class="tab-block client-tab-block current">
                        <div class="text">Client</div>
                    </div>
                    <div class="tab-block facture-tab-block">
                        <div class="text">Facture</div>
                    </div>
                    <div class="tab-block devis-tab-block">
                        <div class="text">Devis</div>
                    </div>
                    <div class="tab-block reglement-tab-block">
                        <div class="text">Règlements</div>
                        <div class="number">2</div>
                    </div>
                    <div class="tab-block doc-tab-block">
                        <div class="text">Docs</div>
                        <div class="number">6</div>
                    </div>
                </div>

                <div class="popup-detail-wrapper client-detail-wrapper display">
                    <div class="left-section">
                        <div class="editable-block title">
                            <input type="text" class="editable-text label" placeholder="Nom de société / association / particulier" value="Champagne Canard Duchene" />
                        </div>
                        <div class="value">
                            30 rue des mimosas
                            <br>
                            39 030 Reims
                        </div>
                        <div class="value phone-number-wrap">
                            Téléphone entreprise : +3368289251
                        </div>
                        <div class="value">
                            Email général : fgiron@canard-duchene.fr
                        </div>
                    </div>

                    <div class="right-section">
                        <div class="toggle-option-block">
                            <i class="material-icons">more_vert</i>

                            <div class="outer-toggle-option-menu">
                                <div class="toggle-option-menu">
                                    <div class="toggle-menu-block add-client-contact">
                                        Ajouter un contact
                                    </div>
                                    <div class="toggle-menu-block view-client-info">
                                        Voir la fiche client
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="vertical-block company-info-block">
                            <div class="label title">
                                Contact(s)
                            </div>
                            <div class="contact-person-wrap">
                                <div class="edit-icon-wrap">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M2.43 15.67L16.118 1.972a.749.749 0 01.531-.222h.001c.199 0 .39.079.53.22l4.85 4.85a.75.75 0 010 1.061l-13.7 13.69zM22.568 5.943l.493-.493A3.168 3.168 0 0024 3.2c0-.864-.336-1.668-.937-2.258C21.861-.272 19.748-.271 18.549.94l-.493.493zM2.024 16.678l-1.99 6.348a.749.749 0 00.941.94l6.347-1.99zM6.97 8.788a.744.744 0 00.53-.22l4.842-4.842c.259-.258.605-.36.944-.335l1.184-1.185a2.705 2.705 0 00-3.189.459L6.439 7.507a.75.75 0 00.531 1.281z"
                                        ></path>
                                    </svg>
                                </div>
                                <div class="value">
                                    Eliel Brancard
                                </div>
                                <div class="value">
                                    ivonise.eliel@gmail.com
                                </div>
                                <div class="value">
                                    06 14 78 15 46
                                </div>
                            </div>
                        </div>

                        <div class="vertical-block create-date-wrap">
                            Créé le 25/06/2020 à 15:00
                        </div>
                    </div>
                </div>

                <div class="popup-detail-wrapper pdf-doc-detail-wrapper facture-detail-wrapper">
                    <div class="inner-document-wrapper extra-top-margin">
                        <div class="doc-link-wrap">
                            <a href="#" target="_blank">Voir la fiche facture</a>
                        </div>
                        <iframe src="https://booking.selfizee.fr/f/V1ZSdmVVOXVkSHBQYWxrMlNXMUdhbVJIYkhaaWFVazNZM3B2ZUUxRWIybGpSMUp0WkcxV2VXTXliSFppYVVrM1kzcHZlVTlwU25CYVEwazNZVlJ2ZWs1VVNUUlBNekE5" type="application/pdf" title="facture"></iframe>
                    </div>
                </div>

                <div class="popup-detail-wrapper pdf-doc-detail-wrapper devis-detail-wrapper">
                    <div class="inner-document-wrapper extra-top-margin">
                        <div class="doc-link-wrap">
                            <a href="#" target="_blank">Voir la fiche devis</a>
                        </div>
                        <iframe src="https://booking.selfizee.fr/f/V1ZSdmVVOXVkSHBQYWxrMlNXMUdhbVJIYkhaaWFVazNZM3B2ZUUxRWIybGpSMUp0WkcxV2VXTXliSFppYVVrM1kzcHZlVTlwU25CYVEwazNZVlJ2ZWs1VVNUUlBNekE5" type="application/pdf" title="facture"></iframe>
                    </div>
                </div>

                <div class="popup-detail-wrapper document-detail-wrapper reglement-section">
                    <div class="inner-document-wrapper">

                        <div class="title">
                            Règlements
                        </div>

                        <div class="customized-table">
                            <div class="tr">
                                <div class="column main-type-column">
                                    <div class="th">Type</div>
                                    <div class="td">
                                        <i class="fa mr-3 fa-arrow-up"></i>
                                    </div>
                                </div>
                                <div class="column date-column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        05/10/20
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact lié</div>
                                    <div class="td">
                                        <a href="#" target="_blank">Cyrielle MARCHAL</a>
                                    </div>
                                </div>
                                <div class="column few-letter-value-column">
                                    <div class="th">Paiement</div>
                                    <div class="td">
                                        CB
                                    </div>
                                </div>
                                <div class="column few-letter-value-column">
                                    <div class="th">Propriétaire</div>
                                    <div class="td">
                                        <?php echo $this->Html->image('reglements-en-retard/avatar-2.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                    </div>
                                </div>
                                <div class="column reference-column">
                                    <div class="th">Référence</div>
                                    <div class="td">
                                        <a href="#" target="_blank">FK-202009-03766</a>
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant</div>
                                    <div class="td right-align">
                                        314,30 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Restant</div>
                                    <div class="td right-align">
                                        0 &euro;
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="column main-type-column">
                                    <div class="th">Type</div>
                                    <div class="td">
                                        <i class="fa mr-3 fa-arrow-up"></i>
                                    </div>
                                </div>
                                <div class="column date-column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        04/10/20
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact lié</div>
                                    <div class="td">
                                        <a href="#" target="_blank">LE CORGNE</a>
                                    </div>
                                </div>
                                <div class="column few-letter-value-column">
                                    <div class="th">Paiement</div>
                                    <div class="td">
                                        CB
                                    </div>
                                </div>
                                <div class="column few-letter-value-column">
                                    <div class="th">Propriétaire</div>
                                    <div class="td">
                                        <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                    </div>
                                </div>
                                <div class="column reference-column">
                                    <div class="th">Référence</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202010-75403</a>
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant</div>
                                    <div class="td right-align">
                                        116,70 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Restant</div>
                                    <div class="td right-align">
                                        272,30 &euro;
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="popup-detail-wrapper document-detail-wrapper doc-section">
                    <div class="inner-document-wrapper">
                        <div class="title">
                            Devis
                        </div>

                        <div class="customized-table">
                            <div class="tr">
                                <div class="column">
                                    <div class="th">N&deg;</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202007-25172</a>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact</div>
                                    <div class="td">
                                        Benjamin G.
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        13/07/2020
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant HT</div>
                                    <div class="td right-align">
                                        2900 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant TTC</div>
                                    <div class="td right-align">
                                        3480 &euro;
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Expire</div>
                                    <div class="td">
                                        31/08/2020
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="column">
                                    <div class="th">N&deg;</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202007-25404</a>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact</div>
                                    <div class="td">
                                        Benjamin G.
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        16/07/2020
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant HT</div>
                                    <div class="td right-align">
                                        190 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant TTC</div>
                                    <div class="td right-align">
                                        228 &euro;
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Expire</div>
                                    <div class="td">
                                        16/08/2020
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inner-document-wrapper">
                        <div class="title">
                            Facture
                        </div>

                        <div class="customized-table">
                            <div class="tr">
                                <div class="column">
                                    <div class="th">N&deg;</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202007-25172</a>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact</div>
                                    <div class="td">
                                        Benjamin G.
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        13/07/2020
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant HT</div>
                                    <div class="td right-align">
                                        2900 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant TTC</div>
                                    <div class="td right-align">
                                        3480 &euro;
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Expire</div>
                                    <div class="td">
                                        31/08/2020
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="column">
                                    <div class="th">N&deg;</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202007-25404</a>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact</div>
                                    <div class="td">
                                        Benjamin G.
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        16/07/2020
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant HT</div>
                                    <div class="td right-align">
                                        190 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant TTC</div>
                                    <div class="td right-align">
                                        228 &euro;
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Expire</div>
                                    <div class="td">
                                        16/08/2020
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inner-document-wrapper">
                        <div class="title">
                            Avoir
                        </div>

                        <div class="customized-table">
                            <div class="tr">
                                <div class="column">
                                    <div class="th">N&deg;</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202007-25172</a>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact</div>
                                    <div class="td">
                                        Benjamin G.
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        13/07/2020
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant HT</div>
                                    <div class="td right-align">
                                        2900 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant TTC</div>
                                    <div class="td right-align">
                                        3480 &euro;
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Expire</div>
                                    <div class="td">
                                        31/08/2020
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="column">
                                    <div class="th">N&deg;</div>
                                    <div class="td">
                                        <a href="#" target="_blank">DK-202007-25404</a>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Contact</div>
                                    <div class="td">
                                        Benjamin G.
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Date</div>
                                    <div class="td">
                                        16/07/2020
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant HT</div>
                                    <div class="td right-align">
                                        190 &euro;
                                    </div>
                                </div>
                                <div class="column amount-column">
                                    <div class="th right-align">Montant TTC</div>
                                    <div class="td right-align">
                                        228 &euro;
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="th">Expire</div>
                                    <div class="td">
                                        16/08/2020
                                    </div>
                                </div>
                                <div class="column status-column">
                                    <div class="th">Etat</div>
                                    <div class="td">
                                        <div class="status-icon brouillon"></div>

                                        <div class="customized-select">
                                            <div class="selected-value-block">
                                                <div class="text value" option-id="1">Brouillon</div>
                                                <div class="select-icon-wrap">
                                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                                </div>
                                            </div>

                                            <div class="outer-option-list-wrap">
                                                <div class="option-list-wrap">
                                                    <div class="search-option-wrap">
                                                        <svg viewBox="0 0 512 512">
                                                            <path
                                                                d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"
                                                            />
                                                            <path
                                                                d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"
                                                            />
                                                        </svg>

                                                        <input type="text" placeholder="Rechercher ..." />
                                                    </div>

                                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                                        <div class="option-block selected value" option-id="1">
                                                            Brouillon
                                                        </div>
                                                        <div class="option-block value" option-id="2">
                                                            Statut 2
                                                        </div>
                                                        <div class="option-block value" option-id="3">
                                                            Statut 3
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-wrapper popup-below-tab-section">
                    <div class="tab-block comment-tab-block current">
                        <div class="text">Commentaires</div>
                    </div>
                    <div class="tab-block activity-tab-block">
                        <div class="text">Activité</div>
                    </div>
                </div>

                <div class="below-section-content">

                    <div class="inner-below-section-content comment-section display">

                        <div class="top-header-wrap add-comment-wrap">
                            <div class="btn-text">Ajouter un commentaire</div>
                        </div>

                        <div class="comment-content-wrapper">

                            <div class="comment-wrap">

                                <div class="comment-header">

                                    <div class="toggle-option-block">
                                        <i class="material-icons">more_vert</i>
                                    </div>

                                    <div class="popup-comment-avatar">
                                        <?php echo $this->Html->image('pipeline/avatar-male-3.jpg', ["alt" => "Ravi", "class" => "avatar"]); ?>
                                    </div>

                                    <div class="right-section">

                                        <div class="popup-comment-title">
                                            Matboard links
                                        </div>

                                        <div class="popup-comment-date">
                                            Just now
                                        </div>

                                    </div>

                                </div>

                                <div class="comment-content">

                                    <textarea class="editable-text customized-scrollbar">

                                        <?php
                                            echo "Hey guys, here's the link to the Matboards: https://matboard.io/39284662";
                                        ?>

                                    </textarea>

                                </div>

                            </div>

                            <div class="comment-wrap">

                                <div class="comment-header">

                                    <div class="toggle-option-block">
                                        <i class="material-icons">more_vert</i>
                                    </div>

                                    <div class="popup-comment-avatar">
                                        <?php echo $this->Html->image('pipeline/avatar-female-1.jpg', ["alt" => "Avatar 2", "class" => "avatar"]); ?>
                                    </div>

                                    <div class="right-section">

                                        <div class="popup-comment-title">
                                            Utilisateur 2
                                        </div>

                                        <div class="popup-comment-date">
                                            Yesterday
                                        </div>

                                    </div>

                                </div>

                                <div class="comment-content">

                                    <textarea class="editable-text customized-scrollbar">

                                        <?php
                                            echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";
                                        ?>

                                    </textarea>

                                </div>

                            </div>

                            <div class="comment-wrap">

                                <div class="comment-header">

                                    <div class="toggle-option-block">
                                        <i class="material-icons">more_vert</i>
                                    </div>

                                    <div class="popup-comment-avatar">
                                        <?php echo $this->Html->image('pipeline/avatar-male-4.jpg', ["alt" => "Avatar 3", "class" => "avatar"]); ?>
                                    </div>

                                    <div class="right-section">

                                        <div class="popup-comment-title">
                                            Utilisateur 3
                                        </div>

                                        <div class="popup-comment-date">
                                            2 days ago
                                        </div>

                                    </div>

                                </div>

                                <div class="comment-content">

                                    <textarea class="editable-text customized-scrollbar">

                                        <?php
                                            echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";
                                        ?>

                                    </textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="inner-below-section-content activity-section">

                        <div class="top-header-wrap">
                            <div class="btn-text">2 activités</div>
                        </div>

                        <div class="activity-container">

                            <div class="activity-block">

                                <?php echo $this->Html->image('pipeline/avatar-male-3.jpg', ["alt" => "Ravi", "class" => "avatar"]); ?>

                                <div class="right-section">

                                    <div class="top-description">
                                        <span class="name">Ravi</span> joined the project here
                                    </div>

                                    <div class="bottom-description">
                                        5 hours ago
                                    </div>

                                </div>

                            </div>

                            <div class="activity-block">

                                <?php echo $this->Html->image('pipeline/avatar-female-4.jpg', ["alt" => "Kristina", "class" => "avatar"]); ?>

                                <div class="right-section">

                                    <div class="top-description">
                                        <span class="name">Kristina</span> added the task <a href="#">Produce broad concept directions</a>
                                    </div>

                                    <div class="bottom-description">
                                        Yesterday
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- === End of Late Popup Container === -->


    <!-- === Client Contact Popup Container === -->

    <?= $this->element('Opportunites/edit_client_contact') ?>

    <!-- === End of Client Contact Popup Container === -->


    <!-- === Client Company Popup Container === -->
    <?= $this->element('Opportunites/edit_info_client') ?>
    <!-- === End of Client Company Popup Container === -->


    <!-- === Email Editor Popup Container === -->

    <div class="popup-container email-editor-popup-container">

        <div class="outer-popup-container">

            <div class="popup-close-wrap">

                <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

            </div>

            <div class="inner-popup-container customized-scrollbar white-background-scrollbar">

                <div class="title-wrap">

                    <div class="title">Nouveau mail</div>

                    <div class="email-date-sent">
                        <span class="created-label">Envoyé</span> le 4 Août 2020 - 8:45
                    </div>

                </div>

                <div class="email-header-wrapper">

                    <div class="inner-email-header-wrap send-to-wrapper">

                        <div class="label">
                            Envoyer à :
                        </div>

                        <input type="text" class="value" placeholder="Adresse(s) e-mail" value="daniellorenzo@domain.com">

                    </div>

                    <div class="inner-email-header-wrap cc-to-wrapper">

                        <div class="label">
                            Cc :
                        </div>

                        <input type="text" class="value" placeholder="Adresse(s) e-mail">

                    </div>

                    <div class="inner-email-header-wrap email-subject-wrapper">

                        <div class="label">
                            Objet :
                        </div>

                        <input type="text" class="value" placeholder="Sujet" value="Envoi de devis / Sujet exemple">

                    </div>

                </div>

                <div class="email-content-wrapper">

                    <div class="middle-email-option-wrapper">

                        <label class="attach-file-wrapper">

                            <input type="file" multiple>

                            <div class="attach-file-icon-wrap">

                                <svg viewBox="0 0 91.002 91.002"><path d="M80.845 47.014l-3.127-3.128L39.509 5.678c-7.57-7.57-19.888-7.57-27.458 0-7.329 7.329-7.542 19.093-.685 26.704.105.135.2.274.323.396l32.546 32.548c5.155 5.152 13.541 5.153 18.695 0 5.156-5.156 5.156-13.543.003-18.697L44.303 28a4.611 4.611 0 00-6.521 6.521L56.411 53.15a4.001 4.001 0 01-5.657 5.656L18.568 26.618c-3.976-3.977-3.975-10.444 0-14.422 3.978-3.975 10.444-3.975 14.42 0l38.208 38.21 3.129 3.127c6.454 6.454 6.454 16.957 0 23.41-6.453 6.454-16.955 6.454-23.41 0L10.488 36.519a4.61 4.61 0 10-6.52 6.521l40.426 40.425c10.05 10.05 26.401 10.052 36.451.003 10.051-10.052 10.05-26.405 0-36.454z"/></svg>

                                <!--<svg viewBox="-25 0 510 510.257"><path d="M427.828 314.484l-37.738-37.738-169.817-169.809c-31.296-31.062-81.816-30.968-112.996.211-31.18 31.18-31.273 81.7-.21 112.997l169.808 169.859c6.945 6.95 18.21 6.95 25.16 0 6.945-6.95 6.945-18.211 0-25.16l-169.808-169.86c-17.368-17.367-17.368-45.52 0-62.886 17.367-17.368 45.52-17.368 62.886 0l169.86 169.808 37.738 37.735c31.266 31.277 31.254 81.976-.02 113.238-31.277 31.262-81.972 31.254-113.238-.024l-31.441-31.453L81.91 245.301l-12.582-12.578C25.352 187.37 25.91 115.12 70.578 70.449 115.25 25.781 187.5 25.223 232.852 69.2l188.68 188.684a17.797 17.797 0 0029.765-7.977 17.796 17.796 0 00-4.606-17.183l-188.68-188.68c-59.09-58.82-154.64-58.711-213.593.246-58.957 58.953-59.066 154.504-.246 213.594l188.68 188.68 31.488 31.453c45.41 43.617 117.375 42.89 161.89-1.641 44.52-44.527 45.227-116.492 1.598-161.89zm0 0"/></svg>-->

                            </div>

                            <div class="file-attached">
                                Glisser ou cliquer pour joindre fichier(s)
                            </div>

                        </label>

                        <div class="select-email-model-wrapper">

                            <div class="customized-select">

                                <div class="selected-value-block">

                                    <div class="text value" option-id="1">Choisir un modèle de mail</div>
                                    <div>
                                        <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                    </div>

                                </div>

                                <div class="outer-option-list-wrap">

                                    <div class="option-list-wrap">

                                        <div class="search-option-wrap">

                                            <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                            <input type="text" placeholder="Rechercher un modèle de mail ..." />

                                        </div>

                                        <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">

                                            <div class="option-block selected value" option-id="1">
                                                Choisir un modèle de mail
                                            </div>
                                            <div class="option-block value" option-id="2">
                                                Modèle mail 1
                                            </div>
                                            <div class="option-block value" option-id="3">
                                                Modèle mail 2
                                            </div>
                                            <div class="option-block value" option-id="4">
                                                Modèle mail 3
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <textarea class="email-editor"></textarea>

                    <div class="email-content-sent">

                        Bonjour,<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Cordialement,<br><br>L' Équipe Selfizee
                    </div>

                </div>

                <div class="bottom-submit-btn-wrap">
                    <div class="btn-validate">
                        Envoyer
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- === End of Email Editor Popup Container === -->


    <!-- === Add Comment Popup Container === -->
    <?= $this->element('Opportunites/add_commentaire') ?>
    <!-- === End of Add Comment Popup Container === -->


</div>
