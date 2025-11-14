$(document).ready(function () {
    
    $('#devis_type_doc').on('shown.bs.modal', function(e) {
        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        $('#modif_type').val(link.attr('data-value'));
        $('#modif_type').selectpicker('refresh');
        modal.find('.num_devis').text(link.attr('data-indent'));
    });
    
});