$(document).ready(function () {

    var BASE_URL = $('#id_baseUrl').val();
    /*var langue = $('#lang').val();
    if(langue === "en") { langue = "en-gb" ;};*/

    $('#calendar').fullCalendar({
        slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
        minTime: '08:00:00',
        maxTime: '19:00:00',
        defaultView: 'month',
        handleWindowResize: true,

        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar !!!
        //eventLimit: true, // allow "more" link when too many events
        selectable: true,

        viewRender: function (event, element)
        {
            /*intervalStart = view.intervalStart;
            intervalEnd = view.intervalEnd;
            view_start = view.start.format("YYYY-MM-DD");
            view_end = view.end.format("YYYY-MM-DD");*/
        },

        events: {
            url: BASE_URL + 'fr/dateEvenements/getDatesEvents',
            type: 'GET',
            data: {
                'key': $("#key").val(),
                'type_evenement': $("#type_evenement").val(),
                'type_animation': $("#type_animation").val(),
                'antenne': $("#antenne").val(),
                'type_client': $("#type_client").val(),
            },
            error: function() {
                alert('there was an error while fetching events!');
            }
        },
        eventClick: function (calEvent, jsEvent, view) {
            //alert(view.name);//alert('Event: ' + calEvent.date_fin);
            $.ajax({
                url: BASE_URL + 'fr/dateEvenements/getEvent/'+parseInt(calEvent.id),
                dataType: 'json',
                success: function (data) {
                    $('#edit_infos').text(data.evenement.type_evenement.nom+" - "+data.evenement.type_animation.nom);
                    $('#my-event').modal('show');
                }
            });
        },
        eventRender: function (event, element)
        {
            //alert(event.backgroundColor);
            return '<a class="fc-day-grid-event fc-h-event fc-event fc-start fc-not-end" style="cursor:pointer;background-color:'+event.backgroundColor +';">' +
             '<div class="fc-content">' +
                ' <span class="fc-title">' +
                '<div style="text-align: left;">'+event.nom_event +' - '+ event.lieu_event +'<br>'+event.nom_client+' - '+event.type_client+'</div>' +
                '</span>' +
                '</div>'
                '</a>';
        }
    });

});

/*
var BASE_URL = $('#id_baseUrl').val();
$.ajax({
    url: BASE_URL + 'fr/evenements/getDatesEvents',
    data: {
        start : view_start,
        end : view_end,
    },
    dataType: 'json',
    type: 'get',
    success: function (data) {
        //console.log(data);
        $.each(data, function (clef, valeur) {
            console.log(valeur.date_debut);
            date_debut = new Date(valeur.date_debut);
            date_debut = date_debut.getFullYear()+"-"+("0"+(date_debut.getMonth()+1))+"-"+date_debut.getDate();
            date_fin = new Date(valeur.date_fin);
            date_fin = date_fin.getFullYear()+"-"+("0"+(date_fin.getMonth()+1))+"-"+date_fin.getDate();
            donnees.push({
                title: 'Event '+clef,
                start: date_debut,
                end: date_fin,
                className: 'bg-info'
            });
        });
        console.log(defaultEvents);
        console.log(donnees);
        console.log(new Date($.now() + 348000000));
    }
});*/
