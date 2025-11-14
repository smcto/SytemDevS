<?= $this->Html->script('ventes/devis_modal.js'); ?>

<?php $documentsInSession = isset($venteEntity->documents) ? collection($venteEntity->documents)->combine('id', 'id') : ''; ?>

<!-- Modal -->
<div class="modal fade" id="modal-devis" tabindex="-1" role="dialog" aria-labelledby="id-modal-devis" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="id-modal-devis">Aperçu du devis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-iframe-devis"><!-- JS IFRAME --></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary btn" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<div class="mt-4 container-devis-client">
    <h6>Sélectionner parmi les devis : </h6>
    <div class="row">
        <?php if (isset($documents_devis_clients) && $documents_devis_clients->count() > 0): ?>
                <?php foreach ($documents_devis_clients as $key => $document): ?>
                    <div class="col-md-6">
                        <?php $document_id = $document->id; ?>
                        <?php $this->start('infos_devis') ?>

                            <?php $data_href = $this->Url->build(['controller' => 'ventes', 'action' => 'convertSellsyPdfToDsiplayable', 'url' => $document->url_sellsy], true) ?>
                            Numéro : <?= $document->ident ?> (<a href="#modal-devis" data-href="<?= $data_href ?>" data-toggle="modal" data-target="#modal-devis">Voir le document</a>) <br>
                            Montant HT : <?= $this->Number->precision($document->montant_ht, 2); ?> EUR <br>
                            <?php if ($document->date): ?>
                                Le : <?= $document->date->format('d/m/Y') ?>
                            <?php endif ?>
                            <a href="<?= $document->url_sellsy ?>">url</a>

                        <?php $this->end() ?>
                        <?= $this->Form->control("documents[_ids][$document_id]", [
                            'checked' => isset($venteEntity->documents) ? (in_array($document->id, $documentsInSession->toArray()) ? 'checked' : '') : '', 
                            'value' => $document_id, 
                            'label' => $this->fetch('infos_devis'), 
                            'type'=>'checkbox', 
                            'escape' => false, 
                            'hiddenField' => false]); 
                        ?>
                    </div>
                <?php endforeach ?>
        <?php else: ?>
            <div class="col-md-12">Aucun devis</div>
        <?php endif ?>
    </div>
</div>