// MAJ de l'état d'une vente
$('#change-state').on('shown.bs.modal', function(event) {
    event.preventDefault();

    srcBtn = $(event.relatedTarget);
    calledModal = $(event.currentTarget);
    venteConsommableId = srcBtn.attr('data-id');
    currentForm = calledModal.find('form');
    currentForm.attr('action', srcBtn.attr('data-action'));
    etatFacturationSelect = calledModal.find('select.etat_facturation');
    etatFacturationSelect = calledModal.find('select.etat_facturation');
    dateFacturationInput = calledModal.find('input.date_facturation');
    saveBtn = currentForm.find('button.save');
    dateFacturation = srcBtn.attr('data-date-facturation');

    // --- si pre maj ----
    etatFacturationSelect.val(srcBtn.attr('data-etat-facturation'));
    etatFacturationSelect.selectpicker('refresh');
    dateFacturationInput.val(dateFacturation);
}); 