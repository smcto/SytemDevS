// à cause du conflit sidebarmenu.js dû faire :
$('ul.nav-tabs a').on('click', function(e) {
    e.preventDefault();
    link = $(e.currentTarget);
    id = link.attr('id');
    ulId = $(this).parents('ul.nav-tabs').attr('id');
    $('div#'+ulId).find('.fade').removeClass('show , active');
    $('div#'+ulId).find('[aria-labelledby="'+id+'"]').addClass('show active');
});

$('.coord_bq').on('changed.bs.select', function(event) {
    event.preventDefault();
    var url = base_url+'fr/AjaxDevisPreferences/getInfoBanque/'+$(this).val();
    $.get(url, function(data) {
        $('.infos-bq-ajax').html(data)
    });
});

$('#display-virement').click(function(event) {
    $('.container-infos-bq').toggleClass('d-none');
});

$('#display-cheque').click(function(event) {
    $('.container-libelle').toggleClass('d-none');
});