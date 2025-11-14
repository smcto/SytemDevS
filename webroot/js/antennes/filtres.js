$(document).ready(function() {
    // Vue map capture filtre
    $('.vue_filtre').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var key = $('#key').val();
        var etat = $('#etat').val();
        var ville = $('#ville-principale').val();
        var fond_vert = $('#fond_vert').val();

        var filtre_key = '';
        var filtre_etat = '';
        var filtre_ville = '';
        var filtre_vert = '';
        var filtre = '';

        // filtre réel
        if(key != '')
            filtre_key = 'key='+key;

        filtre += filtre_key;

        // filtre réel
        if(etat > 0)
            filtre_etat = 'etat='+etat;

        if(filtre_etat != '' && filtre != '')
            filtre += '&'+filtre_etat;
        else
            filtre += filtre_etat;

        // filtre réel
        if(ville > 0)
            filtre_ville = 'ville_principale='+ville;

        if(filtre_ville != '' && filtre != '')
            filtre += '&'+filtre_ville;
        else
            filtre += filtre_ville;

        // filtre réel
        if(fond_vert > 0)
            filtre_vert = 'fondvert='+fond_vert;

        if(filtre_vert != '' && filtre != '')
            filtre += '&'+filtre_vert;
        else
            filtre += filtre_vert;

        if(typeof url != 'undefined')
            url += (filtre != '' ? '?'+filtre : '');

        window.location.href = url;

    });
});