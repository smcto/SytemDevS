$(document).ready(function () {
    
    $('.radios-client-1').on('change', function () {
        $('.nouveau-client').addClass('hide');
        $('#client-id').prop('required',true);
        $('.client-required').prop('required',false);
        $('.existing-client').removeClass('hide');
    });

    $('.radios-client-2').on('change', function () {
        $('.nouveau-client').removeClass('hide');
        $('#client-id').prop('required',false);
        $('.client-required').prop('required',true);
        $('.existing-client').addClass('hide');
    });
    
    $('.radios-client-3').on('change', function () {
        $('.nouveau-client').addClass('hide');
        $('#client-id').prop('required',false);
        $('.client-required').prop('required',false);
        $('.existing-client').addClass('hide');
    });

    $('#duplicate_doc').on('shown.bs.modal', function(e) {
        
        $('.radios-client-1').trigger('change');

        var modal = $(e.currentTarget);
        var link = $(e.relatedTarget);
        var url = link.attr('data-href');
        modal.find('form').attr('action', url);
        modal.find('form').submit(function(event) {});
        modal.find('#title').text(link.attr('data-title'));
    });

    $('#duplicate_doc').on('hidden.bs.modal', function () {
        $('.nouveau-client').removeClass('hide');
    })

});
