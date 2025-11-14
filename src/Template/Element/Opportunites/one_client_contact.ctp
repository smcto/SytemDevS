<div class="contact-person-wrap" id="id_clientContact_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>">

    <div class="edit-icon-wrap" data-client="<?= $clientContact->client_id ?>" data-clientcontact="<?= $clientContact->id ?>">

        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M2.43 15.67L16.118 1.972a.749.749 0 01.531-.222h.001c.199 0 .39.079.53.22l4.85 4.85a.75.75 0 010 1.061l-13.7 13.69zM22.568 5.943l.493-.493A3.168 3.168 0 0024 3.2c0-.864-.336-1.668-.937-2.258C21.861-.272 19.748-.271 18.549.94l-.493.493zM2.024 16.678l-1.99 6.348a.749.749 0 00.941.94l6.347-1.99zM6.97 8.788a.744.744 0 00.53-.22l4.842-4.842c.259-.258.605-.36.944-.335l1.184-1.185a2.705 2.705 0 00-3.189.459L6.439 7.507a.75.75 0 00.531 1.281z"/></svg>

    </div>
    
    <div class="value">
        <span id="id_clientContact_nom_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>"><?= $clientContact->nom ?></span>  <span id="id_clientContact_prenom_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>"><?= $clientContact->prenom ?></span>
    </div>
    <div id="id_clientContact_email_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>" class="value"><?= $clientContact->email ?></div>
    <div id="id_clientContact_position_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>" class="value"><?= $clientContact->position ?></div>
    <div id="id_clientContact_tel_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>" class="value"><?= $clientContact->tel ?></div>
    <div class="hide" id="id_clientContact_note_<?= $clientContact->client_id ?>_<?= $clientContact->id ?>" class="value"><?= $clientContact->nonte ?></div>

</div>