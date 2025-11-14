<div class="popup-container small-popup-container client-contact-popup-container">
    <form id="id_editAddClientContact">
        <input type="hidden" name="opportunite_id">
        <input type="hidden" name="client_id">
        <input type="hidden" name="client_contact_id">
        <div class="outer-popup-container">

            <div class="popup-close-wrap">

                <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

            </div>

            <div class="inner-popup-container customized-scrollbar white-background-scrollbar">

                <div class="title">
                    Éditer ce contact
                </div>

                <div class="outer-client-input-wrapper">

                    <div class="client-contact-wrap">

                        <div class="label">
                            Nom :
                        </div>

                        <div class="editable-block">
                            <input type="text" name="nom" class="editable-text value" placeholder="Entrer nom" >
                        </div>

                    </div>

                    <div class="client-contact-wrap">

                        <div class="label">
                            Prénom :
                        </div>

                        <div class="editable-block">
                            <input type="text" class="editable-text value" placeholder="Entrer prénom" name="prenom">
                        </div>

                    </div>

                    <div class="client-contact-wrap">

                        <div class="label">
                            Adresse e-mail :
                        </div>

                        <div class="editable-block">
                            <input type="text" class="editable-text value" placeholder="Entrer adresse e-mail" name="email">
                        </div>

                    </div>

                    <div class="client-contact-wrap">

                        <div class="label">
                            Tél :
                        </div>

                        <div class="editable-block">
                            <input type="text" class="editable-text value" placeholder="Entrer tél" name="tel">
                        </div>

                    </div>

                    <div class="client-contact-wrap">

                        <div class="label">
                            Fonction :
                        </div>

                        <div class="editable-block">
                            <input type="text" class="editable-text value" placeholder="Entrer fonction" name="position">
                        </div>

                    </div>

                    <div class="client-contact-wrap">

                        <div class="label">
                            Commentaire :
                        </div>

                        <textarea name="note" class="value" placeholder="Entrer commentaire"></textarea>

                    </div>

                </div>

                <div class="bottom-submit-btn-wrap">
                    <div class="pipeline-small-loader-container-edit"><div class="loading-spinner"></div></div>

                    <div class="ClientContactSumbit btn-validate submit-validate">
                        Valider
                    </div>
                    <div class=" btn-validate submit-add" id="id_addNewClientContact">
                        Ajouter
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>