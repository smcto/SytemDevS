// Select multiple
$('#select-all').click(function(event) {
    if ($(this).is(':checked')) {
        $('[checkox-item]').prop('checked', true);
    } else {
        $('[checkox-item]').prop('checked', false)
    }
});

$('.liste-items').on('click', 'input[type="checkbox"]', function(event) {
    if ($('input[type="checkbox"]:checked').length > 0) {
        $('.bloc-actions').removeClass('d-none');
    } else {
        $('.bloc-actions').addClass('d-none');
    }
});

$('a.active-col-checkbox').on('click', function(event) {
    event.preventDefault();
    $('table td.col-checkbox , table th.col-checkbox').toggleClass('d-none');
});
