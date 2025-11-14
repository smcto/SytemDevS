<div class="top-header-wrapper">
    
    <div class="left-section">

        <div class="client-name">
            <?= $factureEntity->client->full_name ?>
        </div>

        <div class="quotation-wrapper">
            <div class="quotation-name-wrap">
                <div class="quotation-name">Facture <?= $factureEntity->indent ?></div>
            </div>
            <img alt="Image" src="<?= $factureEntity->commercial->url_photo ?>" class="employee-avatar" data-title="<?= $factureEntity->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
            <div class="payment-status-wrap">
                <div class="status status-icon <?= $factureEntity->status ?>"></div>
                <div class="status-type"><?= @$facture_status[$factureEntity->status] ?></div>
            </div>
        </div>

        <?php if ($factureEntity->get('ObjetTronquer')) : ?>
            <div class="product-name-wrap">
                <svg viewBox="0 0 451.846 451.847"><path d="M345.441 248.292L151.154 442.573c-12.359 12.365-32.397 12.365-44.75 0-12.354-12.354-12.354-32.391 0-44.744L278.318 225.92 106.409 54.017c-12.354-12.359-12.354-32.394 0-44.748 12.354-12.359 32.391-12.359 44.75 0l194.287 194.284c6.177 6.18 9.262 14.271 9.262 22.366 0 8.099-3.091 16.196-9.267 22.373z"/></svg>
                <div class="name">
                    <?= $factureEntity->get('ObjetTronquer') ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <div class="right-section">

        <div class="date-wrapper">
            <div class="date-wrap">
                <div class="label">Date facture :</div>
                <div class="value"><?= $factureEntity->date_crea ? $factureEntity->date_crea->format('d/m/y') : "-" ?></div>
            </div>
            <div class="date-wrap">
                <div class="label">Date échéance :</div>
                <div class="value"><?= $factureEntity->date_prevu_echeance ? $factureEntity->date_prevu_echeance->format('d/m/y') : "-" ?></div>
            </div>
            <div class="date-wrap">
                <div class="label">Depuis création :</div>
                <div class="value"><?= $factureEntity->get('DayForCreated') ?> jours</div>
            </div>
            <div class="date-wrap">
                <div class="label">Retard échéance :</div>
                <div class="value"><?= $factureEntity->get('DayFromRetard') ?> jours</div>
            </div>
        </div>

        <div class="amount-wrapper">
            <div class="amount-wrap total-wrap">
                <div class="top-label">Total facture</div>
                <div class="ttc-amount"><?= $this->Utilities->formatCurrency($factureEntity->total_ttc) ?> TTC</div>
                <div class="ht-amount"><?= $this->Utilities->formatCurrency($factureEntity->total_ht) ?> HT</div>
            </div>
            <div class="amount-wrap remaining-wrap">
                <div class="top-label">Restant dû</div>
                <div class="ttc-amount"><?= $this->Utilities->formatCurrency($factureEntity->get('ResteEcheanceImpayee')) ?> TTC</div>
                <div class="ht-amount"><?= $this->Utilities->formatCurrency($factureEntity->get('ResteEcheanceImpayeeSansTva')) ?> HT</div>
            </div>
        </div>

    </div>

</div>

<input type="hidden" id="facture" value="<?= $factureEntity->id ?>">


<div class="middle-header-wrapper">

    <div class="step-wrapper">
        <div class="step-block <?= (! $factureEntity->progression || $factureEntity->progression == 'en_retard')? 'current' : '' ?>">
            En retard
            <input type="hidden" class="value" value="en_retard">
        </div>
        <div class="step-block <?= $factureEntity->progression == 'relance1' ? 'current' : '' ?>">
            Relance 1
            <input type="hidden" class="value" value="relance1">
        </div>
        <div class="step-block <?= $factureEntity->progression == 'relance2' ? 'current' : '' ?>">
            Relance 2
            <input type="hidden" class="value" value="relance2">
        </div>
        <div class="step-block <?= $factureEntity->progression == 'relance3' ? 'current' : '' ?>">
            Relance 3
            <input type="hidden" class="value" value="relance3">
        </div>
        <div class="step-block <?= $factureEntity->progression == 'lr' ? 'current' : '' ?>">
            LR
            <input type="hidden" class="value" value="lr">
        </div>
        <div class="step-block <?= $factureEntity->progression == 'injonction' ? 'current' : '' ?>">
            Injonction
            <input type="hidden" class="value" value="injonction">
        </div>
    </div>

    <div class="issue-detail-wrapper">

        <div class="editable-block issue-type">
            <textarea class="editable-text" id="description_retard" placeholder="Aucun commentaire">
                <?= $factureEntity->description_retard ?>
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
        <div class="number"><?= count($factureEntity->facture_reglements) ?></div>
    </div>
    <div class="tab-block doc-tab-block">
        <div class="text">Docs</div>
        <div class="number">
            <?= count($factureEntity->client->devis) + count($factureEntity->client->devis_factures) + count($factureEntity->client->avoirs) ?>
        </div>
    </div>
</div>

<div class="popup-detail-wrapper client-detail-wrapper display">
    <div class="left-section">
        <div class="value">
            <b><?= $factureEntity->client->full_name ?></b>
            <br><br>
            <?= $factureEntity->client->adresse ?>
            <br>
            <?= $factureEntity->client->cp?> <?= $factureEntity->client->ville;?>
            <br>
            <?= $factureEntity->client->adresse_2; ?>
        </div>
        <div class="value phone-number-wrap <?= $factureEntity->client->telephone ? : 'hide' ?>">
            Téléphone entreprise : <?= $factureEntity->client->telephone ?>
        </div>
        <div class="value <?= $factureEntity->client->email ? : 'hide' ?>">
            Email général : <?= $factureEntity->client->email ?>
        </div>
        
        <div class="vertical-block create-date-wrap">
            <?php if ($factureEntity->client->id_in_wp): ?>
                Compte créé automatiquement le : <i><?= $factureEntity->client->created->format('d/m/Y') ?></i>
            <?php elseif($factureEntity->client->user_id): ?>
                Compte créé par <i><?= $factureEntity->client->user->get('FullName') ?></i> le : <i><?= $factureEntity->client->created->format('d/m/Y') ?></i>
            <?php elseif($factureEntity->client->get('CommercialDuPremierDevis')): ?>
                Compte créé par <i><?= $factureEntity->client->get('CommercialDuPremierDevis') ?></i> le : <i><?= $factureEntity->client->created->format('d/m/Y') ?></i>
            <?php else: ?>
                Compte créé le : <i><?= $factureEntity->client->created->format('d/m/Y') ?></i>
            <?php endif ?>
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
                    <input type="hidden" value="<?= $factureEntity->client_id ?>" id="id-client-add-contact">
                    <div class="toggle-menu-block view-client-info">
                        <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $factureEntity->client_id]) ?>" target="_blank">Voir la fiche client</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="vertical-block company-info-block">
            <div class="label title">
                Contact(s)
            </div>
            <?php foreach ($factureEntity->client->client_contacts as $contact) : ?>
            <div class="contact-person-wrap">
                <div class="edit-icon-wrap">
                    <input type="hidden" value="<?= $contact->id ?>" class="id-contact">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M2.43 15.67L16.118 1.972a.749.749 0 01.531-.222h.001c.199 0 .39.079.53.22l4.85 4.85a.75.75 0 010 1.061l-13.7 13.69zM22.568 5.943l.493-.493A3.168 3.168 0 0024 3.2c0-.864-.336-1.668-.937-2.258C21.861-.272 19.748-.271 18.549.94l-.493.493zM2.024 16.678l-1.99 6.348a.749.749 0 00.941.94l6.347-1.99zM6.97 8.788a.744.744 0 00.53-.22l4.842-4.842c.259-.258.605-.36.944-.335l1.184-1.185a2.705 2.705 0 00-3.189.459L6.439 7.507a.75.75 0 00.531 1.281z"
                        ></path>
                    </svg>
                </div>
                <div class="value">
                    <?= $contact->full_name ?>
                </div>
                <div class="value">
                    <?= $contact->email ?>
                </div>
                <div class="value">
                    <?= $contact->tel ?>
                </div>
                <div class="value">
                    <?= $contact->contact_note ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="popup-detail-wrapper pdf-doc-detail-wrapper facture-detail-wrapper">
    <div class="inner-document-wrapper extra-top-margin">
        <div class="doc-link-wrap">
            <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $factureEntity->id]) ?>" target="_blank">Voir la fiche facture</a>
        </div>
        <iframe src="<?= $this->Url->build($factureEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="facture"></iframe>
    </div>
</div>

<div class="popup-detail-wrapper pdf-doc-detail-wrapper devis-detail-wrapper">
    <div class="inner-document-wrapper extra-top-margin">
        
        <?php if ($factureEntity->devi) : ?>
        
            <div class="doc-link-wrap">
                <a href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $factureEntity->devi->id]) ?>" target="_blank">Voir la fiche devis</a>
            </div>
            <iframe src="<?= $this->Url->build($factureEntity->devi->get('PublicPdfUrl')) ?>" type="application/pdf" title="facture"></iframe>
        <?php else : ?>

            <div class="draft">
                Aucun devis
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="popup-detail-wrapper document-detail-wrapper reglement-section">
    <div class="inner-document-wrapper">

        <?php if ($factureEntity->facture_reglements) : ?>
        
            <div class="title">
                Règlements
            </div>

            <div class="customized-table">

                <?php foreach ($factureEntity->facture_reglements as $reglement) : ?>
                <div class="tr">
                    <div class="column main-type-column">
                        <div class="th">Type</div>
                        <div class="td">
                            <i class="fa mr-3 <?= $reglement->type == 'credit' ? 'fa-arrow-up' : 'fa-arrow-down' ?>"></i>
                        </div>
                    </div>
                    <div class="column date-column">
                        <div class="th">Date</div>
                        <div class="td">
                            <?= $reglement->date->format('d/m/y') ?>
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

                            <?php if ($reglement->user) : ?>
                                <img alt="Image" src="<?= $reglement->user->url_photo ?>" class="avatar" data-title="<?= $reglement->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                            <?php else : ?>
                                <img alt="Image" src="<?= $commercial->url_photo ?>" class="avatar" data-title="Automatique" data-toggle="tooltip" />
                            <?php endif; ?>                                
                        </div>
                    </div>
                    <div class="column reference-column">
                        <div class="th">Référence</div>
                        <div class="td">
                            <?php
                                $link = $reglement->reference;
                                if(!empty($reglement->devis_factures)){
                                    foreach ($reglement->devis_factures as $facture) {
                                        if($reglement->reference == $facture->indent) {
                                            $link = $this->Html->link($reglement->reference,['controller'=>'DevisFactures','action'=>'view', $facture->id], ['target' => '_blank']).'<br>';
                                        }
                                    }
                                }

                                if($link == $reglement->reference) {
                                    if(!empty($reglement->devis)){
                                        foreach ($reglement->devis as $devis) {
                                            if($reglement->reference == $devis->indent) {
                                                $link = $this->Html->link($reglement->reference,['controller'=>'Devis','action'=>'view', $devis->id], ['target' => '_blank']).'<br>';
                                            }
                                        }
                                    }
                                }

                                if($link == $reglement->reference) {
                                    if(!empty($reglement->avoirs)){
                                        foreach ($reglement->avoirs as $avoir) {
                                            if($reglement->reference == $avoir->indent) {
                                                $link = $this->Html->link($reglement->reference,['controller'=>'Avoirs','action'=>'view', $avoir->id], ['target' => '_blank']).'<br>';
                                            }
                                        }
                                    }
                                }

                                echo $link;
                            ?>
                        </div>
                    </div>
                    <div class="column amount-column">
                        <div class="th right-align">Montant</div>
                        <div class="td right-align">
                            <?= $this->Utilities->formatCurrency($reglement->montant) ?>
                        </div>
                    </div>

                </div>

                <?php endforeach; ?>

            </div>
        
        <?php else : ?>
        
            <div class="draft">
                Aucun règlement
            </div>
        <?php endif; ?>
        
    </div>
</div>

<div class="popup-detail-wrapper document-detail-wrapper doc-section">
    
    <?php $docs = count($factureEntity->client->devis) + count($factureEntity->client->devis_factures) + count($factureEntity->client->avoirs); ?>
    
    <?php if ($docs) : ?>
    
        <?php if (count($factureEntity->client->devis)) : ?>

            <div class="inner-document-wrapper">
                <div class="title">
                    Devis
                </div>

                <div class="customized-table">

                    <?php foreach ($factureEntity->client->devis as $devis) : ?>
                        <div class="tr">
                            <div class="column">
                                <div class="th">N&deg;</div>
                                <div class="td">
                                    <a href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $devis->id]) ?>" target="_blank"><?= $devis->indent ?></a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Contact</div>
                                <div class="td">
                                    <?php if ($devis->commercial) : ?>
                                        <img alt="Image" src="<?= $devis->commercial->url_photo ?>" class="avatar" data-title="<?= $devis->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        --
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date</div>
                                <div class="td">
                                    <?= $devis->date_crea->format('d/m/y') ?>
                                </div>
                            </div>
                            <div class="column amount-column">
                                <div class="th right-align">Montant HT</div>
                                <div class="td right-align">
                                    <?= $devis->get('TotalHtWithCurrency') ?>
                                </div>
                            </div>
                            <div class="column amount-column">
                                <div class="th right-align">Montant TTC</div>
                                <div class="td right-align">
                                    <?= $devis->get('TotalTtcWithCurrency') ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Expire</div>
                                <div class="td">
                                    <?php if (!$devis->is_in_sellsy): ?>
                                        <?= $devis->date_sign_before ? $devis->date_sign_before->format('d/m/y') : '' ?>
                                    <?php else: ?>
                                        <?= $devis->date_validite ? $devis->date_validite->format('d/m/y') : '' ?>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="column status-column">
                                <div class="th">Etat</div>
                                <div class="td">
                                    <div class="table-status-wrap">
                                        <i class="fa fa-circle <?= $devis->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devis->status] ?>" data-original-title="Brouillon"></i> 
                                        <?= @$devis_status[$devis->status] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if (count($factureEntity->client->devis_factures)) : ?>

            <div class="inner-document-wrapper">
                <div class="title">
                    Facture
                </div>

                <div class="customized-table">
                    <?php foreach ($factureEntity->client->devis_factures as $factures) : ?>
                        <div class="tr">
                            <div class="column">
                                <div class="th">N&deg;</div>
                                <div class="td">
                                    <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $factures->id]) ?>" target="_blank"><?= $factures->indent ?></a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Contact</div>
                                <div class="td">
                                    <?php if ($factures->commercial) : ?>
                                        <img alt="Image" src="<?= $factures->commercial->url_photo ?>" class="avatar" data-title="<?= $factures->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        --
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date</div>
                                <div class="td">
                                    <?= $factures->date_crea?$factures->date_crea->format('d/m/y') : $factures->created->format('d/m/y'); ?>
                                </div>
                            </div>
                            <div class="column amount-column">
                                <div class="th right-align">Montant HT</div>
                                <div class="td right-align">
                                    <?= $factures->get('TotalHtWithCurrency') ?>
                                </div>
                            </div>
                            <div class="column amount-column">
                                <div class="th right-align">Montant TTC</div>
                                <div class="td right-align">
                                    <?= $factures->get('TotalTtcWithCurrency') ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Expire</div>
                                <div class="td">
                                    <?php if (!$factures->is_in_sellsy): ?>
                                        <?= $factures->date_sign_before ? $factures->date_sign_before->format('d/m/y') : '' ?>
                                    <?php else: ?>
                                        <?= $factures->date_validite ? $factures->date_validite->format('d/m/y') : '' ?>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="column status-column">
                                <div class="th">Etat</div>
                                <div class="td">

                                    <div class="table-status-wrap">
                                        <i class="fa fa-circle <?= $factures->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$facture_status[$factures->status] ?>" data-original-title="Brouillon"></i> 
                                        <?= @$facture_status[$factures->status] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>

        <?php if (count($factureEntity->client->avoirs)) : ?>

            <div class="inner-document-wrapper">
                <div class="title">
                    Avoir
                </div>

                <div class="customized-table">

                    <?php foreach ($factureEntity->client->avoirs as $avoir) : ?>
                        <div class="tr">
                            <div class="column">
                                <div class="th">N&deg;</div>
                                <div class="td">
                                    <a href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'view', $avoir->id]) ?>" target="_blank"><?= $avoir->indent ?></a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Contact</div>
                                <div class="td">
                                    <?php if ($avoir->commercial) : ?>
                                        <img alt="Image" src="<?= $avoir->commercial->url_photo ?>" class="avatar" data-title="<?= $avoir->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        --
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date</div>
                                <div class="td">
                                    <?= $avoir->date_crea->format('d/m/Y'); ?>
                                </div>
                            </div>
                            <div class="column amount-column">
                                <div class="th right-align">Montant HT</div>
                                <div class="td right-align">
                                    <?= $avoir->get('TotalHtWithCurrency') ?>
                                </div>
                            </div>
                            <div class="column amount-column">
                                <div class="th right-align">Montant TTC</div>
                                <div class="td right-align">
                                    <?= $avoir->get('TotalTtcWithCurrency') ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Expire</div>
                                <div class="td">
                                    <?php if (!$avoir->is_in_sellsy): ?>
                                        <?= $avoir->date_sign_before ? $avoir->date_sign_before->format('d/m/y') : '' ?>
                                    <?php else: ?>
                                        <?= $avoir->date_validite ? $avoir->date_validite->format('d/m/y') : '' ?>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="column status-column">
                                <div class="th">Etat</div>
                                <div class="td">

                                    <div class="table-status-wrap">
                                        <i class="fa fa-circle <?= $avoir->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$facture_status[$avoir->status] ?>" data-original-title="Brouillon"></i> 
                                        <?= @$facture_status[$avoir->status] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endif; ?>
    
    <?php else : ?>

        <div class="draft">
            Aucun document
        </div>
    <?php endif; ?>
    
</div>

<div class="tab-wrapper popup-below-tab-section">
    <div class="tab-block comment-tab-block current">
        <div class="text">Commentaire(s)</div>
        <div class="number">
            <?= count($factureEntity->commentaires_factures) ?>
        </div>
    </div>
    <div class="tab-block activity-tab-block">
        <div class="text">Activité</div>
        <div class="number">
            <?= count($factureEntity->statut_historiques) +1 ?>
        </div>
    </div>
</div>

<div class="below-section-content">

    <div class="inner-below-section-content comment-section display">

        <div class="top-header-wrap add-comment-wrap">
            <a href="javascript:void(0);" class="btn-text" >Ajouter un commentaire</a>
        </div>

        <div class="comment-content-wrapper">

            <?php if ($factureEntity->commentaires_factures) : ?>
            
                <?php foreach ($factureEntity->commentaires_factures as $key => $commentaire): ?>
                    <div class="comment-wrap">

                        <div class="comment-header">

                            <?php if ($commentaire->user_id == $currentUser) : ?>
                            
                                <div class="toggle-option-block">
                                    <i class="material-icons">more_vert</i>
                                    <div class="outer-toggle-option-menu">
                                        <div class="toggle-option-menu">
                                            <div class="toggle-menu-block modify-toggle-block">
                                                <input type="hidden" value="<?= $commentaire->id ?>" class="commentaire-id">
                                                Modifier
                                            </div>
                                            <div class="toggle-menu-block delete-toggle-block">
                                                <input type="hidden" value="<?= $commentaire->id ?>" class="commentaire-id">
                                                Supprimer
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <?php endif; ?>

                            <div class="popup-comment-avatar">
                                <?php echo $this->Html->image($commentaire->user->url_photo, ["alt" => "Ravi", "class" => "avatar"]); ?>
                            </div>

                            <div class="right-section">

                                <div class="popup-comment-title">
                                    <?= $commentaire->user->full_name ?>
                                </div>

                                <div class="popup-comment-date">
                                    <?= $commentaire->created->i18nFormat('dd/M/Y à HH:mm', 'Europe/Paris')  ?>
                                </div>

                            </div>

                        </div>

                        <div class="comment-content">

                            <?= $commentaire->content ?>

                        </div>

                    </div>

                <?php endforeach; ?>
            
            <?php else : ?>
            
                <div class="comment-wrap">
                    <div class="comment-content">

                            Aucun commentaire
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="inner-below-section-content activity-section">

        <div class="top-header-wrap">
            <div class="btn-text"><?= count($factureEntity->statut_historiques) + 1 ?> activités</div>
        </div>

        <div class="activity-container">

            <?php foreach ($factureEntity->statut_historiques as $statut_historique) : ?>
            
                <div class="activity-block">

                    <?php if ($statut_historique->user) : ?>
                        <img alt="Image" src="<?= $statut_historique->user->url_photo ?>" class="avatar" data-title="<?= $statut_historique->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                    <?php else : ?>
                        <img alt="Image" src="<?= $commercial->url_photo ?>" class="avatar" data-title="Automatique" data-toggle="tooltip" />
                    <?php endif; ?>         

                    <div class="right-section">

                        <div class="top-description">
                            <span class="name"><?= $statut_historique->user ? $statut_historique->user->get('FullNameShort') : 'Commercial' ?></span>
                            <?php if (in_array($statut_historique->statut_document, array_keys($progression))) : ?>
                                
                                a changé la progression en "<?= $progression[$statut_historique->statut_document] ?>"
                            
                            <?php endif; ?>    
                            <?php if (in_array($statut_historique->statut_document, array_keys($facture_status))) : ?>
                                
                                a changé l'état de la facture en "<?= $facture_status[$statut_historique->statut_document] ?>"
                            
                            <?php endif; ?>                    
                            <?php if ($statut_historique->statut_document == 'add_comment') : ?>
                                
                                a ajouté un commentaire
                                
                            <?php endif; ?>        
                            <?php if ($statut_historique->statut_document == 'delete_comment') : ?>
                                
                                a supprimé un commentaire
                                
                            <?php endif; ?>
                              
                        </div>

                        <div class="bottom-description">
                            <?= $statut_historique->time->i18nFormat('dd/M/Y à HH:mm', 'Europe/Paris')  ?>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
            

            <div class="activity-block">

                <img alt="Image" src="<?= $factureEntity->commercial->url_photo ?>" class="avatar" data-title="<?= $factureEntity->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                <div class="right-section">

                    <div class="top-description">
                        <span class="name"><?= $factureEntity->commercial->get('FullNameShort') ?></span> a créé la facture
                    </div>

                    <div class="bottom-description">
                        <?= $factureEntity->created->i18nFormat('dd/M/Y à HH:mm', 'Europe/Paris') ?>
                    </div>

                </div>

            </div>

        </div>

    </div>
    
    <br>

</div>

<!-- === End of Late Popup Container === -->
