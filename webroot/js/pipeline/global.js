$(document).ready(function () {
    var baseUrl = $("#id_baseUrl").attr('value');
    $(".crm_oneListeEtape").scroll(function(){
        var idEtape = $(this).attr('data-etape');
        var div = $(this).get(0);
        var nbrPage = $(this).attr('data-nbrpage');
        var currentPage = $(this).find('.crm_oneOpportunite').last().attr('data-page');
        var delegate = $(this);
        if(nbrPage > currentPage){
            page = parseInt(currentPage) + 1;
            if(div.scrollTop + div.clientHeight + 650 >= div.scrollHeight) {
               if(!delegate.hasClass('loader')){
                    $.ajax({
                        type: "GET",    
                        url: baseUrl+'fr/opportunites/listOppEtape/'+idEtape+"/"+page,
                        dataType: 'html',
                        beforeSend:function(){
                            $("#id_etapeFooter_"+idEtape).addClass('loader');
                            delegate.addClass('loader');
                        },
                        success: function(data){
                            $("#id_etapeFooter_"+idEtape).removeClass('loader');
                            delegate.removeClass('loader');
                            if(data){
                                $('#id_cardListEtape_'+idEtape).append(data);
                            }
                        },
                    });
                }
            }
        }
    });
});

/*const droppable = new Draggable.Droppable(document.querySelectorAll('.kanban-board'), {
  draggable: '.card-kanban',
  dropzone: '.kanban-col'
});

droppable.on('droppable:dropped', () => console.log('droppable:dropped'));
droppable.on('droppable:returned', () => console.log('droppable:returned'));*/

/*const containers = document.querySelectorAll('.kanban-board')

const droppable = new Draggable.Droppable(containers, {
    draggable: '.card-kanban',
    dropzone: '.kanban-col'
});

droppable.on('droppable:dropped', () => console.log('droppable:dropped'));
droppable.on('droppable:returned', () => console.log('droppable:returned'));

*/

//console.log('mrKanban'+mrKanban);

/*var draggable = new Draggable(document.querySelectorAll('ul'), {
      draggable: 'li'
    });

draggable.on('drag:start', () => console.log('drag:start'));
draggable.on('drag:move', () => console.log('drag:move'));
draggable.on('drag:stop', () => console.log('drag:stop'));*/