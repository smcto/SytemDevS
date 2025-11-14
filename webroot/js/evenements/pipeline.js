$(document).ready(function() {
    /* $("#answers li").draggable({
        connectToSortable: '.kl_container',
        helper: 'clone',
        revertDuration: 0
    });*/

    $(".kl_listeEtape").sortable({
        connectWith: '.kl_listeEtape',
        revert: true
    });

    $(".kl_listeEtape li").draggable({
        connectToSortable: '.kl_listeEtape',
        revert: "invalid",
        stop: function( event, ui ) {
            //var idDragged = $(this ).attr('id');
            //console.log('Id atterissage '+idAtterissage);
        }
    });
    
    $( ".kl_listeEtape" ).droppable({
      drop: function( event, ui ) {
        /*var idAtterissage = $(this ).attr('id');
        console.log('Id atterissage '+idAtterissage);*/
        // Get id of the item that was moved
        //var idMoved = $(this).attr('data-item');
        var idRelation = $(ui.draggable).attr("data-item");
        //idRelation = idRelation.slice(9);
        console.log("Deplaced "+idRelation);

        // How to get the destination ID that the item was dropped to?
        var idNouveauEtape = this.id.slice(9);
        
        //idNouveauEtape = idNouveauEtape.slice('')
        console.log("destination "+idNouveauEtape);  // "destinationA" or "destinationB"
        deplaceEvenement(idRelation, idNouveauEtape);
      }
    });


    $("ul.kl_listeEtape, ul.kl_listeEtape li").disableSelection();
});

function deplaceEvenement(idRelation, idNouveauEtape){
    var URL_BASE = $("#id_baseUrl").val();
    

    
    if(idRelation){
        $.ajax({
            url: URL_BASE+"fr/EvenementPipeEtapes/deplace/"+idRelation,
            type: 'POST',
            data : "pipe_etape_id="+idNouveauEtape,
            beforeSend : function(){
               //$(sender).find(".kl_loader").removeClass("hide");
            },
            success: function (data, textStatus, jqXHR) {
                   //$("#id_contentContact").empty();
                //$("#id_onePhoto_"+idTodelete).remove();
                //$grid.masonry();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(textStatus);
                alert("Une erreur est survenue. Veuillez réessayer.")
            }
        });
    }
     
}