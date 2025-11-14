// ----- checkbox tr collapse AJAX ----------
$('.tr-container-checkbox input[type="checkbox"]').click(function(event) {
    self = $(this);
    dataTarget  = self.attr('data-target');

    if (self.is(':checked')) {
        $('tr#'+dataTarget).removeClass('d-none');
        $('tr#'+dataTarget).find('input[type="number"]').val('');
    } else {
        $('tr#'+dataTarget).addClass('d-none');
    }
});

$('.tr-container-checkbox input[type="checkbox"]').each(function(index, el) {
    self = $(this);
    dataTarget  = self.attr('data-target');

    if (self.is(':checked')) {
        $('tr#'+dataTarget).removeClass('d-none');
    } else {
        $('tr#'+dataTarget).addClass('d-none');
    }
});
// ----- END checkbox tr collapse AJAX ----------