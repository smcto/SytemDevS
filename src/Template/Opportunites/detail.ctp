<input type="hidden" id="id_currentOppInPopup" value="<?= $opportunite->id ?>">
<div class="outer-popup-container">

<div class="popup-close-wrap">

    <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

</div>

<div class="inner-popup-container customized-scrollbar white-background-scrollbar">

    <div class="popup-pipe-header">

        <div class="pipe-name">

            <!--<div class="editable-block">
                <input type="text" class="editable-text" placeholder="Titre de l'événement" value="Salon de la mer - 18/09 - 3 jours avec fond vert">
            </div>-->

            <div class="editable-block">
                <div class="pipeline-small-loader-container">
                    <div class="loading-spinner"></div>
                </div>
                <textarea name="nom" class="editable-text crm_editOpp" placeholder="Titre de l'événement"><?= $opportunite->nom ?></textarea>
            </div>

        </div>

        <div class="right-header-section">

            <div class="status-wrap">

                <div class="status-icon <?= $opportunite->opportunite_statut->indent ?>"></div>


                <div class="customized-select">

                    <div class="selected-value-block">

                        <div class="text status-name <?= $opportunite->opportunite_statut->indent ?>" option-id="<?= $opportunite->opportunite_statut->id ?>"><?= $opportunite->opportunite_statut->nom ?></div>
                        <div class="select-icon-wrap">
                            <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                        </div>

                    </div>

                    <div class="outer-option-list-wrap">

                        <div class="option-list-wrap">

                            <div class="search-option-wrap">

                                <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                <input type="text" placeholder="Rechercher ..." />

                            </div>

                            <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                <?php foreach($opportuniteStatuts as $opportuniteStatut){ ?>
                                <div data-oclass="<?= $opportunite->opportunite_statut->indent ?>" data-nclass="<?= $opportuniteStatut->indent ?>" class="option-block changeStatut <?= $opportuniteStatut->id == $opportunite->opportunite_statut_id ? 'selected' :'' ?>  value" option-id="<?= $opportuniteStatut->id ?>" option-opp = "<?= $opportunite->id ?>">
                                    <?= $opportuniteStatut->nom ?>
                                </div>
                                <?php } ?>
                            </div>

                        </div>

                    </div>

                </div>


            </div>

            <div class="amount">

                <div class="editable-block">
                    <input type="text" name="montant_potentiel" class="editable-text crm_editOpp currency" value="<?= $opportunite->montant_potentiel ?>">&euro;
                </div>

            </div>

        </div>

    </div>

    <div class="popup-below-header-wrapper">

        <div class="pipe-step-container">

            <div class="step-name current">
                <span><?= $opportunite->pipeline->nom ?></span>
            </div>

            <div class="step-name">
                <span><?= $opportunite->pipeline_etape->nom ?></span>
            </div>

        </div>

        <div class="right-section">

            <div class="tag-container">

                <div class="tag-list-content-wrap">
                    <?php if(empty($opportunite->opportunite_tags)){ ?>
                        <div class='tag tag_vide'><div class="text">Ajouter des tags</div></div>
                    <?php }else{
                        foreach($opportunite->opportunite_tags as $tag){
                    ?>
                    <div class="tag" data-tag="<?= $tag->id ?>">
                        <div  class="text"><?= $tag->nom ?></div>
                        <svg viewBox="0 0 348.333 348.334"><path d="M336.559 68.611L231.016 174.165l105.543 105.549c15.699 15.705 15.699 41.145 0 56.85-7.844 7.844-18.128 11.769-28.407 11.769-10.296 0-20.581-3.919-28.419-11.769L174.167 231.003 68.609 336.563c-7.843 7.844-18.128 11.769-28.416 11.769-10.285 0-20.563-3.919-28.413-11.769-15.699-15.698-15.699-41.139 0-56.85l105.54-105.549L11.774 68.611c-15.699-15.699-15.699-41.145 0-56.844 15.696-15.687 41.127-15.687 56.829 0l105.563 105.554L279.721 11.767c15.705-15.687 41.139-15.687 56.832 0 15.705 15.699 15.705 41.145.006 56.844z"/></svg>
                    </div>
                    <?php  }
                    }
                    ?>

                </div>

                <textarea class="customized-scrollbar" placeholder="Entrer des tags"></textarea>

            </div>


            <div class="edit-icon-wrap">

                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M2.43 15.67L16.118 1.972a.749.749 0 01.531-.222h.001c.199 0 .39.079.53.22l4.85 4.85a.75.75 0 010 1.061l-13.7 13.69zM22.568 5.943l.493-.493A3.168 3.168 0 0024 3.2c0-.864-.336-1.668-.937-2.258C21.861-.272 19.748-.271 18.549.94l-.493.493zM2.024 16.678l-1.99 6.348a.749.749 0 00.941.94l6.347-1.99zM6.97 8.788a.744.744 0 00.53-.22l4.842-4.842c.259-.258.605-.36.944-.335l1.184-1.185a2.705 2.705 0 00-3.189.459L6.439 7.507a.75.75 0 00.531 1.281z"/></svg>

            </div>

        </div>

    </div>

    <div class="tab-section client-event-tab-section">

        <div class="tab-block event-tab-block current">
            Événement
        </div>

        <div class="tab-block client-tab-block">
            Client
        </div>

        <div class="tab-block original-tab-block">
            Brief client original
        </div>

    </div>

    <div class="outer-popup-detail-wrapper">

        <form id="id_formdetailEvenementOpp">
        <div id="id_detailEvenementOpp" class="popup-detail-wrapper event-detail-wrapper for-event-tab-wrapper display">
            <input type="hidden" id="id_ofEvenement" name="id" value="<?= $opportunite->evenement_id ?>">
            <input type="hidden"  name="opportunite_id" value="<?= $opportunite->id ?>">
            <div class="inner-detail-wrapper">

                <div class="detail-group-wrapper left-section">

                    <div class="popup-detail-block">
                        <div class="label">Nom de l'événement :</div>
                        <div class="editable-block">
                            <input type="text" name="nom_event" class="editable-text value" placeholder="Nom de l'événement" value="<?= @$evenement->nom_event ?>">
                        </div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Type d'événement :</div>

                        <div class="customized-select">

                            <div class="selected-value-block">
                                <input type="hidden" name="type_evenement_id" value="<?= $opportunite->type_evenement_id  ?>">
                                <div class="text value" option-id="<?= @$evenement->type_evenement_id  ?>"><?= !empty($evenement->type_evenement->nom) ? $evenement->type_evenement->nom : 'Séléctionner'  ?></div>
                                <div class="select-icon-wrap">
                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                </div>

                            </div>

                            <div class="outer-option-list-wrap">

                                <div class="option-list-wrap">

                                    <div class="search-option-wrap">

                                        <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                        <input type="text" placeholder="Rechercher ..." />

                                    </div>

                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">

                                        <?php foreach($typeEvenements as $typeEvenement){ ?>
                                        <div class="option-block value <?= $typeEvenement->id == $opportunite->type_evenement->id ? 'selected': '' ?>" option-id="<?= $typeEvenement->id ?>">
                                            <?= $typeEvenement->nom ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Type de borne :</div>

                        <div class="customized-select">

                            <div class="selected-value-block">
                                <input type="hidden" name="opportunite_type_borne_id" value="<?= $opportunite->opportunite_type_borne_id  ?>">
                                <div class="text value" option-id="<?= @$evenement->opportunite_type_borne_id ?>"><?= !empty($evenement->opportunite_type_borne->nom) ? $evenement->opportunite_type_borne->nom :'Séléctionner' ?></div>
                                <div>
                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                </div>

                            </div>

                            <div class="outer-option-list-wrap">

                                <div class="option-list-wrap">

                                    <div class="search-option-wrap">

                                        <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                        <input type="text" placeholder="Rechercher ..." />

                                    </div>

                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                        <?php foreach($opportuniteTypeBornes as $opportuniteTypeBorne){ ?>
                                        <div class="option-block value <?= $opportuniteTypeBorne->id == @$evenement->opportunite_type_borne_id ? 'selected' : '' ?>" option-id="<?= $opportuniteTypeBorne->id ?>">
                                            <?= $opportuniteTypeBorne->nom ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Nombre de borne(s) :</div>
                        <div class="editable-block number-block">
                            <input type="number" name="nbr_borne" class="editable-text value" placeholder="0" value="<?= @$evenement->nbr_borne ?>">
                        </div>
                    </div>

                </div>

                <div class="detail-group-wrapper right-section">

                    <div class="popup-detail-block">
                        <div class="label">Date de l'événement :</div>

                        <div class="editable-block">

                            <input name="date_event" class="editable-text value" placeholder="Date de l'événement" value="<?= !empty($evenement->date_event) ? $evenement->date_event : $opportunite->date_debut_event ?>" autocomplete="off" data-toggle="pipeline-datepicker">

                            <!--<input type="text" name="date_event" class="editable-text value" placeholder="Date de l'événement" value="<?= @$evenement->date_event ?>">-->

                        </div>

                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Lieu :</div>
                        <div class="editable-block">
                            <input type="text" name="lieu_exact" class="editable-text value" placeholder="Lieu" value="<?= @$evenement->lieu_exact ?>">
                        </div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Nombre participants :</div>
                        <div class="editable-block number-block">
                            <input type="number" name="nbr_participants" class="editable-text value" placeholder="0" value="<?= @$evenement->nbr_participants ?>">
                        </div>
                    </div>

                    <div class="popup-detail-block fond-vert-detail-block">
                        <div class="label">Option fond vert :</div>

                        <div class="customized-select">
                            <div class="selected-value-block">
                                <input type="hidden" name="option_fond_vert_id" value="<?= @$evenement->option_fond_vert_id  ?>">

                                <div class="text value" option-id="<?= $opportunite->option_fond_vert_id ?>"><?= !empty($evenement->option_fond_vert->nom) ? $evenement->option_fond_vert->nom : 'Séléctionner' ?></div>
                                <div>
                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                </div>

                            </div>

                            <div class="outer-option-list-wrap">

                                <div class="option-list-wrap">

                                    <div class="search-option-wrap">

                                        <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                        <input type="text" placeholder="Rechercher ..." />

                                    </div>

                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                        <?php 
                                        //debug($optionFondVerts);
                                        foreach($optionFondVerts as $optionFondVert){ ?>
                                        <div class="option-block <?= $optionFondVert->id == @$evenement->option_fond_vert_id ? 'selected' :'' ?> value" option-id="<?= $optionFondVert->id ?>">
                                            <?= $optionFondVert->nom ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Votre besoin :</div>
                        <div class="customized-select">

                            <div class="selected-value-block">

                                <input type="hidden" name="besion_borne_id" value="<?= @$evenement->besion_borne_id  ?>">

                                <div class="text value" option-id="<?= $opportunite->besion_borne_id ?>"><?= !empty($evenement->besion_borne->nom) ? $evenement->besion_borne->nom : 'Séléctionner' ?></div>
                                <div>
                                    <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                </div>

                            </div>

                            <div class="outer-option-list-wrap">

                                <div class="option-list-wrap">

                                    <div class="search-option-wrap">

                                        <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                        <input type="text" placeholder="Rechercher ..." />

                                    </div>

                                    <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                        <?php foreach($besionBornes as $besionBorne){ ?>
                                        <div class="option-block <?= $besionBorne->id == @$evenement->besion_borne_id ? 'selected' :'' ?> value" option-id="<?= $besionBorne->id ?>">
                                            <?= $besionBorne->nom ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="inner-detail-wrapper message-detail-wrapper">

                <div class="popup-detail-block">

                    <div class="label">Infos événements :</div>

                    <textarea name="description" class="editable-text value customized-scrollbar" placeholder="Entrer infos événements"><?= @$evenement->description ?></textarea>
                </div>

            </div>

        </div>
        </form>

        <div class="popup-detail-wrapper client-detail-wrapper">

            <form id="id_formEditClient">
                <input type="hidden" name="client_id" id="id_formEditClientId" value="<?= $opportunite->client_id ?>" >
                <input type="hidden" name="opportunite_id" value="<?= $opportunite->id ?>">
                <div class="left-section">

                    <div class="vertical-block">

                        <div class="company-type-wrap">

                            <div class="editable-block title">
                                <input type="text" class="editable-text crm_editClient label" placeholder="Nom de société / association / particulier" value="<?= $opportunite->client->full_name ?>" />
                            </div>

                        </div>

                        <div class="client-info-wrapper">

                            <div class="client-type-block">
                                <div class="type">P</div>
                            </div>

                            <div class="customized-select">

                                <div class="selected-value-block">
                                    <input type="hidden" class="crm_editClient" name="client_type" value="<?= $opportunite->client->client_type  ?>">
                                    <div class="text value" option-id="1"><?= $genres[$opportunite->client->client_type] ?? '' ?></div>
                                    <div>
                                        <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                    </div>

                                </div>

                                <div class="outer-option-list-wrap">

                                    <div class="option-list-wrap">

                                        <div class="search-option-wrap">

                                            <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                            <input type="text" placeholder="Rechercher ..." />

                                        </div>

                                        <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                            <?php foreach ($genres as $key=> $genre) { ?>
                                            <div class="option-block <?= $opportunite->client->client_type == $key ? 'selected' :'' ?> value" type-value="<?= $key ?>" option-id="<?= $key ?>">
                                                <?= $genre ?>
                                            </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="vertical-block professional-client-data-wrapper">

                        <div class="edit-icon-wrap" data-client="<?= $opportunite->client->id?>">

                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M2.43 15.67L16.118 1.972a.749.749 0 01.531-.222h.001c.199 0 .39.079.53.22l4.85 4.85a.75.75 0 010 1.061l-13.7 13.69zM22.568 5.943l.493-.493A3.168 3.168 0 0024 3.2c0-.864-.336-1.668-.937-2.258C21.861-.272 19.748-.271 18.549.94l-.493.493zM2.024 16.678l-1.99 6.348a.749.749 0 00.941.94l6.347-1.99zM6.97 8.788a.744.744 0 00.53-.22l4.842-4.842c.259-.258.605-.36.944-.335l1.184-1.185a2.705 2.705 0 00-3.189.459L6.439 7.507a.75.75 0 00.531 1.281z"/></svg>

                        </div>

                        <div class="inner-left-section">

                            <div class="label">
                                <div id="id_client_addresse_<?= $opportunite->client->id?>"><?= $opportunite->client->adresse ?></div>
                                <div> <span id="id_client_cp_<?= $opportunite->client->id?>"><?= $opportunite->client->cp ?></span> <span id="id_client_ville_<?= $opportunite->client->id?>"> <?= $opportunite->client->ville ?></span></div>
                            </div>

                            <div class="phone-number-wrap">
                                <div class="label">
                                    Tél :
                                </div>
                                <div id="id_client_telephone_<?= $opportunite->client->id?>" class="value"><?= $opportunite->client->telephone ?></div>
                            </div>

                        </div>

                        <div class="inner-right-section">

                            <div class="inner-right-data-wrap professional-data <?= $opportunite->client->client_type == 'person' ? 'hide' : '' ?>">

                                <div class="label">
                                    SIRET :
                                </div>
                                <div id="id_client_siret_<?= $opportunite->client->id?>" class="value"><?= $opportunite->client->siret ?></div>

                            </div>

                            <div class="inner-right-data-wrap professional-data <?= $opportunite->client->client_type == 'person' ? 'hide' : '' ?>">

                                <div class="label">
                                    SIREN :
                                </div>
                                <div id="id_client_siren_<?= $opportunite->client->id?>" class="value"><?= $opportunite->client->siren ?></div>

                            </div>

                            <div class="inner-right-data-wrap professional-data tva-number-wrap <?= $opportunite->client->client_type == 'person' ? 'hide' : '' ?>">

                                <div class="label">
                                    TVA intracommunautaire :
                                </div>
                                <div id="id_client_tva_intra_community_<?= $opportunite->client->id?>" class="value"><?= $opportunite->client->tva_intra_community?$opportunite->client->tva_intra_community . ' %':''?></div>

                            </div>

                        </div>

                    </div>

                    <div class="vertical-block professional-client-data-wrapper below-left-client-wrapper">

                        <div class="inner-left-section">

                            <div class="inner-data-wrap client-group-wrap professional-data <?= $opportunite->client->client_type == 'person' ? 'hide' : '' ?>">

                                <div class="label">
                                    Groupe de clients :
                                </div>

                                <div class="customized-select">

                                    <div class="selected-value-block">
                                        <input type="hidden" class="crm_editClient" name="groupe_client_id" value="<?= @$opportunite->client->groupe_client->id ?>">
                                        <div class="text value" option-id="<?= @$opportunite->client->groupe_client->id ?>"><?= !empty($opportunite->client->groupe_client->nom) ? $opportunite->client->groupe_client->nom : 'Séléctionner' ?></div>
                                        <div>
                                            <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                        </div>

                                    </div>

                                    <div class="outer-option-list-wrap">

                                        <div class="option-list-wrap">

                                            <div class="search-option-wrap">

                                            <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                            <input type="text" placeholder="Rechercher ..." />

                                        </div>

                                        <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                            <?php foreach($groupeClients as $groupeClient){ ?>
                                            <div class="option-block <?= @$opportunite->client->groupe_client->id ==  $groupeClient ->id ? 'selected' : '' ?> value" option-id="<?= $groupeClient->id ?>">
                                                <?= $groupeClient->nom ?>
                                            </div>
                                            <?php } ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="inner-data-wrap how-did-know-wrap">

                                <div class="label">
                                    Comment nous a t'il connu?
                                </div>

                                <div class="customized-select">

                                    <div class="selected-value-block">
                                        <input type="hidden" class="crm_editClient" name="source_lead_id" value="<?= @$opportunite->client->source_lead->id ?>">
                                        <div class="text value" option-id="<?= @$opportunite->client->source_lead->id ?>"><?= !empty($opportunite->client->source_lead->nom) ? $opportunite->client->source_lead->nom :'Séléctionner' ?></div>
                                        <div>
                                            <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                        </div>

                                    </div>

                                    <div class="outer-option-list-wrap">

                                        <div class="option-list-wrap">

                                            <div class="search-option-wrap">

                                                <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                                <input type="text" placeholder="Rechercher ..." />

                                            </div>

                                        <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">
                                            <?php foreach ($sourceLeads as $sourceLead) { ?>
                                            <div class="option-block <?= @$opportunite->client->source_lead->id == $sourceLead->id ? 'selected': '' ?> value" option-id="<?= $sourceLead->id ?>">
                                                <?= $sourceLead->nom ?>
                                            </div>
                                            <?php } ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="inner-right-section">

                            <div class="inner-data-wrap activity-type-wrap professional-data <?= $opportunite->client->client_type == 'person' ? 'hide' : '' ?>">

                                <div class="label">
                                    Secteur d'activité :
                                </div>

                                <div class="customized-select">

                                    <div class="selected-value-block">
                                        <input type="hidden" class="crm_editClient" name="secteurs_activite_id" value="<?= $opportunite->client->secteurs_activite_id ?>">
                                        <div class="text value" option-id="<?= $opportunite->client->secteurs_activite_id ?>"><?= !empty($opportunite->client->secteurs_activite->name) ? $opportunite->client->secteurs_activite->name : 'Séléctionner' ?>  </div>
                                        <div>
                                            <svg viewBox="0 0 256 256"><path d="M225.813 48.907L128 146.72 30.187 48.907 0 79.093l128 128 128-128z"></path></svg>
                                        </div>

                                    </div>

                                    <div class="outer-option-list-wrap">

                                        <div class="option-list-wrap">

                                            <div class="search-option-wrap">

                                                <svg viewBox="0 0 512 512"><path d="M225.474 0C101.151 0 0 101.151 0 225.474c0 124.33 101.151 225.474 225.474 225.474 124.33 0 225.474-101.144 225.474-225.474C450.948 101.151 349.804 0 225.474 0zm0 409.323c-101.373 0-183.848-82.475-183.848-183.848S124.101 41.626 225.474 41.626s183.848 82.475 183.848 183.848-82.475 183.849-183.848 183.849z"/><path d="M505.902 476.472L386.574 357.144c-8.131-8.131-21.299-8.131-29.43 0-8.131 8.124-8.131 21.306 0 29.43l119.328 119.328A20.74 20.74 0 00491.187 512a20.754 20.754 0 0014.715-6.098c8.131-8.124 8.131-21.306 0-29.43z"/></svg>

                                                <input type="text" placeholder="Rechercher ..." />

                                            </div>

                                            <div class="inner-option-list-wrap customized-scrollbar white-background-scrollbar">

                                                <?php foreach($secteurActivites as $secteurActivite) { ?>
                                                <div class="option-block <?= $secteurActivite->id == $opportunite->client->secteurs_activite_id ? 'selected' : '' ?> value" option-id="<?= $secteurActivite->id ?>">
                                                    <?= $secteurActivite->name ?>
                                                </div>
                                                <?php } ?>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            </form>
            <div class="right-section">

                <div class="toggle-option-block">
                    <i class="material-icons">more_vert</i>

                    <div class="outer-toggle-option-menu">
                        <div class="toggle-option-menu">
                            <div data-client="<?= $opportunite->client->id ?>" class="toggle-menu-block add-client-contact">
                                Ajouter un contact
                            </div>
                            <!-- <div class="toggle-menu-block view-client-info">
                                Voir la fiche client
                            </div> -->
                            <?= $this->Html->link('Voir la fiche client',['controller'=>'Clients','action'=>'fiche', $opportunite->client->id ]) ?>
                        </div>
                    </div>

                </div>

                <div class="vertical-block company-info-block">

                    <div class="label title">
                        Contact(s)
                    </div>
                    <div id="id_listeContactOfClient_<?= $opportunite->client->id ?>">
                        <?php 
                        if (!empty($opportunite->client->client_contacts)){ 
                            foreach ($opportunite->client->client_contacts as $key => $clientContact){ 
                                echo $this->element('Opportunites/one_client_contact',['clientContact'=> $clientContact]);
                            } 
                        }
                        ?>
                    </div>

                </div>

                <div class="vertical-block create-date-wrap">
                    Créé le <?= !empty($opportunite->created) ? $opportunite->created->format('d/m/Y à H\h:i') : '' ?>
                </div>

            </div>

        </div>

        <div class="popup-detail-wrapper event-detail-wrapper for-original-tab-wrapper">

            <div class="inner-detail-wrapper">

                <div class="detail-group-wrapper left-section">

                    <div class="popup-detail-block">
                        <div class="label">Nom de l'événement :</div>
                        <div class="value"><?= $opportunite->nom_evenement ?></div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Type d'événement :</div>
                        <div class="value"><?= $opportunite->type_evenement->nom ?></div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Type de borne :</div>
                        <div class="value"><?= @$opportunite->opportunite_type_borne->nom ?></div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Nombre de borne(s) :</div>
                        <div class="value"><?= $opportunite->nbr_borne ?></div>
                    </div>

                </div>

                <div class="detail-group-wrapper right-section">

                    <div class="popup-detail-block">
                        <div class="label">Date de l'événement :</div>
                        <div class="value"><?= $opportunite->date_debut_event ?></div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Lieu :</div>
                        <div class="value"><?= $opportunite->lieu_evenement ?></div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Nombre participants :</div>
                        <div class="value"><?= $opportunite->nbr_participants ?></div>
                    </div>

                    <div class="popup-detail-block fond-vert-detail-block">
                        <div class="label">Option fond vert :</div>
                        <div class="value"><?= @$opportunite->option_fond_vert->nom ?></div>
                    </div>

                    <div class="popup-detail-block">
                        <div class="label">Votre besoin :</div>
                        <div class="value"><?= @$opportunite->besion_borne->nom ?></div>
                    </div>

                </div>

            </div>

            <div class="inner-detail-wrapper message-detail-wrapper">

                <div class="popup-detail-block">

                    <div class="label">Infos événements :</div>
                    <div class="value">
                        <?= $opportunite->demande_precision ?>
                    </div>

                </div>

            </div>

        </div>



    </div>

    <div class="tab-section popup-below-tab-section">

        <div class="tab-block comment-tab-block current">
            <div class="text">Commentaires</div>
            <div class="number" id="id_countCommentaire_<?= $opportunite->id ?>"><?= count($opportunite->opportunite_commentaires) ?></div>
        </div>

        <div class="tab-block mail-tab-block">
            <div class="text">
                Mails
            </div>
            <div class="number">
                3
            </div>
        </div>

        <div class="tab-block doc-tab-block">
            <div class="text">
                Docs
            </div>
            <div class="number">
                <?= count ($opportunite->linked_docs) ?>
            </div>
        </div>

        <div class="tab-block activity-tab-block">
            <div class="text">
                Activité
            </div>
        </div>

    </div>

    <div class="below-section-content">

        <div class="inner-below-section-content comment-section display">

            <div class="top-header-wrap add-comment-wrap">
                <div class="btn-text">Ajouter un commentaire</div>
            </div>

            <div class="comment-content-wrapper" id="id_listeCommetanire_<?= $opportunite->id ?>">
            <?php 
            if(!empty($opportunite->opportunite_commentaires)){
                foreach ($opportunite->opportunite_commentaires as $commentaire) { 
                    echo $this->element('Opportunites/one_commentaire',['commentaire'=>$commentaire]); 
                }
            }
            ?>

                <!-- <div class="comment-wrap">

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

                </div> -->

            </div>

        </div>

        <div class="inner-below-section-content email-section below-section-margin">

            <div class="top-preview-option-wrapper">

                <div class="email-selection-block">
                    <input type="checkbox">
                    <div class="custom-chk-email">
                        <svg viewBox="0 0 511.999 511.999"><path d="M506.231 75.508c-7.689-7.69-20.158-7.69-27.849 0l-319.21 319.211L33.617 269.163c-7.689-7.691-20.158-7.691-27.849 0-7.69 7.69-7.69 20.158 0 27.849l139.481 139.481c7.687 7.687 20.16 7.689 27.849 0l333.133-333.136c7.69-7.691 7.69-20.159 0-27.849z"/></svg>
                    </div>
                </div>

                <div class="delete-email-icon-wrap">
                    <svg viewBox="-57 0 512 512"><path d="M156.371 30.906h85.57v14.399h30.903V28.89C272.848 12.96 259.894 0 243.973 0H154.34c-15.922 0-28.875 12.96-28.875 28.89v16.415h30.906zm0 0M344.21 167.75H54.103c-7.95 0-14.207 6.781-13.567 14.707L64.79 482.363C66.141 499.105 80.105 512 96.883 512h204.543c16.777 0 30.742-12.895 32.094-29.64l24.253-299.903c.645-7.926-5.613-14.707-13.562-14.707zM124.349 480.012c-.325.02-.649.031-.97.031-8.1 0-14.901-6.309-15.405-14.504l-15.2-246.207c-.523-8.52 5.957-15.852 14.473-16.375 8.488-.516 15.852 5.95 16.375 14.473l15.195 246.207c.528 8.52-5.953 15.847-14.468 16.375zm90.433-15.422c0 8.531-6.918 15.45-15.453 15.45s-15.453-6.919-15.453-15.45V218.379c0-8.535 6.918-15.453 15.453-15.453 8.531 0 15.453 6.918 15.453 15.453zm90.758-245.3l-14.512 246.206c-.48 8.211-7.293 14.543-15.41 14.543-.304 0-.613-.008-.922-.023-8.52-.504-15.02-7.817-14.515-16.336l14.508-246.211c.5-8.52 7.789-15.02 16.332-14.516 8.52.5 15.02 7.817 14.52 16.336zm0 0M397.648 120.063L387.5 89.64a19.65 19.65 0 00-18.64-13.43H29.45a19.646 19.646 0 00-18.637 13.43L.664 120.062c-1.957 5.868.59 11.852 5.344 14.836a12.624 12.624 0 006.75 1.946h372.797c2.52 0 4.816-.73 6.75-1.95 4.754-2.984 7.3-8.968 5.343-14.832zm0 0"/></svg>
                </div>

                <div class="search-email-wrapper">

                    <div class="search-block">

                        <svg viewBox="0 0 515.558 515.558"><path d="M378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333C418.889 93.963 324.928.002 209.444.002S0 93.963 0 209.447s93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564L378.344 332.78zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>

                        <input type="text" placeholder="Rechercher ...">
                    </div>

                </div>

                <div class="btn-add-new-row">
                    Créer un nouveau mail
                </div>

            </div>

            <div class="email-list-wrapper">

                <div class="email-preview-wrapper">

                    <div class="outer-selection-block">

                        <div class="email-selection-block">
                            <input type="checkbox">
                            <div class="custom-chk-email">
                                <svg viewBox="0 0 511.999 511.999"><path d="M506.231 75.508c-7.689-7.69-20.158-7.69-27.849 0l-319.21 319.211L33.617 269.163c-7.689-7.691-20.158-7.691-27.849 0-7.69 7.69-7.69 20.158 0 27.849l139.481 139.481c7.687 7.687 20.16 7.689 27.849 0l333.133-333.136c7.69-7.691 7.69-20.159 0-27.849z"/></svg>
                            </div>
                        </div>

                    </div>

                    <div class="inner-list-preview-wrapper">

                        <div class="initial-preview-block">
                            <div class="initial">
                                D
                            </div>
                        </div>

                        <div class="email-right-preview-wrapper">

                            <div class="recipient-preview-block">
                                daniellorenzo@domain.com
                            </div>

                            <div class="subject-preview-block">
                                Sed ut perspiciatis unde omnis iste natus error sit
                            </div>

                            <div class="message-preview-block">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>

                        </div>

                    </div>

                    <div class="sent-date-block">
                        10:15
                    </div>

                </div>

                <div class="email-preview-wrapper">

                    <div class="outer-selection-block">

                        <div class="email-selection-block">
                            <input type="checkbox">
                            <div class="custom-chk-email">
                                <svg viewBox="0 0 511.999 511.999"><path d="M506.231 75.508c-7.689-7.69-20.158-7.69-27.849 0l-319.21 319.211L33.617 269.163c-7.689-7.691-20.158-7.691-27.849 0-7.69 7.69-7.69 20.158 0 27.849l139.481 139.481c7.687 7.687 20.16 7.689 27.849 0l333.133-333.136c7.69-7.691 7.69-20.159 0-27.849z"/></svg>
                            </div>
                        </div>

                    </div>

                    <div class="inner-list-preview-wrapper">

                        <div class="initial-preview-block">
                            <div class="initial">
                                O
                            </div>
                        </div>

                        <div class="email-right-preview-wrapper">

                            <div class="recipient-preview-block">
                                Olivier Donovan
                            </div>

                            <div class="subject-preview-block">
                                Envoi de devis / Sujet exemple
                            </div>

                            <div class="message-preview-block">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>

                        </div>

                    </div>

                    <div class="sent-date-block">
                        4 Août 2020
                    </div>

                </div>

                <div class="email-preview-wrapper">

                    <div class="outer-selection-block">

                        <div class="email-selection-block">
                            <input type="checkbox">
                            <div class="custom-chk-email">
                                <svg viewBox="0 0 511.999 511.999"><path d="M506.231 75.508c-7.689-7.69-20.158-7.69-27.849 0l-319.21 319.211L33.617 269.163c-7.689-7.691-20.158-7.691-27.849 0-7.69 7.69-7.69 20.158 0 27.849l139.481 139.481c7.687 7.687 20.16 7.689 27.849 0l333.133-333.136c7.69-7.691 7.69-20.159 0-27.849z"/></svg>
                            </div>
                        </div>

                    </div>

                    <div class="inner-list-preview-wrapper">

                        <div class="initial-preview-block">
                            <div class="initial">
                                S
                            </div>
                        </div>

                        <div class="email-right-preview-wrapper">

                            <div class="recipient-preview-block">
                                Sylain Kurd
                            </div>

                            <div class="subject-preview-block">
                                Envoi de devis / Sujet exemple
                            </div>

                            <div class="message-preview-block">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>

                        </div>

                    </div>

                    <div class="sent-date-block">
                        30 Juil 2020
                    </div>

                </div>

                <div class="email-preview-wrapper">

                    <div class="outer-selection-block">

                        <div class="email-selection-block">
                            <input type="checkbox">
                            <div class="custom-chk-email">
                                <svg viewBox="0 0 511.999 511.999"><path d="M506.231 75.508c-7.689-7.69-20.158-7.69-27.849 0l-319.21 319.211L33.617 269.163c-7.689-7.691-20.158-7.691-27.849 0-7.69 7.69-7.69 20.158 0 27.849l139.481 139.481c7.687 7.687 20.16 7.689 27.849 0l333.133-333.136c7.69-7.691 7.69-20.159 0-27.849z"/></svg>
                            </div>
                        </div>

                    </div>

                    <div class="inner-list-preview-wrapper">

                        <div class="initial-preview-block">
                            <div class="initial">
                                U
                            </div>
                        </div>

                        <div class="email-right-preview-wrapper">

                            <div class="recipient-preview-block">
                                Ulyss Tail
                            </div>

                            <div class="subject-preview-block">
                                Envoi de devis / Sujet exemple
                            </div>

                            <div class="message-preview-block">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>

                        </div>

                    </div>

                    <div class="sent-date-block">
                        28 Juil 2020
                    </div>

                </div>

            </div>

        </div>

        <div class="inner-below-section-content document-detail-wrapper doc-section below-section-margin">
            <?php 
            if(!empty($opportunite->linked_docs)){
                echo $this->element('Opportunites/doc_opportunite');
            }else{
                echo '<p>Aucun document.</p>';
            }
            ?>

        </div>

        <div class="inner-below-section-content activity-section below-section-margin">

            <div class="top-header-wrap">
                <div class="btn-text">3 activités</div>
            </div>

            <div class="activity-container">

               <?php
               foreach($timelines as $opportuniteTimeline ){
                   echo $this->element('Opportunites/one_activity',['opportuniteTimeline' => $opportuniteTimeline]); 
               }
               ?>

                <!--<div class="activity-block">

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

                </div>-->

            </div>

        </div>

    </div>


</div>
</div>

