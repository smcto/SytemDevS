function setDropdown(currentTr) {
    $(function() {
        currentTr.find("ul.dropdown-menu [data-toggle='dropdown']").unbind('click').on("click", function(event) {
            event.preventDefault();
            event.stopPropagation();

            $('li.dropdown-submenu .dropdown-menu.show').removeClass('show')
            $(this).siblings().toggleClass("show");

            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });

        });

        currentTr.find("ul.dropdown-menu [data-toggle='dropdown']").on('mouseover', function(event) {
            $(this).trigger('click');
        });
    });
};



// marquage visitility
dataVisibilityParams = {};

// initialise à visibilité = true pour toutes les colonnes par défaut
$('.visibility-mark').each(function(index, el) {
    name = $(this).attr('data');
    dataVisibilityParams[name] = $(this).hasClass('isInnactive');
});
$('[name="col_visibility_params"]').val(JSON.stringify(dataVisibilityParams));

$('.visibility-mark').click(function(event) {
    name = $(this).attr('data');
    $(this).toggleClass('isInnactive');
    isInnactive = $(this).hasClass('isInnactive');
    if (isInnactive) {
        $(this).find('.fa').removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        $(this).find('.fa').removeClass('fa-eye-slash').addClass('fa-eye');
    }
    dataVisibilityParams[name] = isInnactive;
    $('[name="col_visibility_params"]').val(JSON.stringify(dataVisibilityParams));
});

// --------------------------------------------------------------------

// à cause du conflit sidebarmenu.js dû faire :
$('ul.nav-tabs a').on('click', function(e) {
    e.preventDefault();
    link = $(e.currentTarget);
    id = link.attr('id');
    ulId = $(this).parents('ul.nav-tabs').attr('id');
    $('div#'+ulId).find('.fade').removeClass('show , active');
    $('div#'+ulId).find('[aria-labelledby="'+id+'"]').addClass('show active');
});

$('#preferences').on('hidden.bs.collapse , shown.bs.collapse', function(event) {
    event.stopPropagation();
    btnPreference = $('.btn-preference');
    if (btnPreference.hasClass('collapsed')) {
        btnPreference.text('Ouvrir');
    } else {
        btnPreference.text('Fermer');
    }
});

$('.coord_bq').on('changed.bs.select', function(event) {
    event.preventDefault();
    var url = base_url+'fr/AjaxDevisPreferences/getInfoBanque/'+$(this).val();
    $.get(url, function(data) {
        $('.infos-bq-ajax').html(data);
    });
});

$('#display-virement').click(function(event) {
    $('.container-infos-bq').toggleClass('d-none');
});

$('#display-cheque').click(function(event) {
    $('.container-libelle').toggleClass('d-none');
});