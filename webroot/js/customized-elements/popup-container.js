// === Close Popup Container ===

$('.popup-close-wrap svg').on('click', function(){

    $(this).parents('.popup-container').removeClass('display');
    $(this).parents('.popup-container').find('.inner-popup-container').scrollTop(0);

});



$('.popup-container').on('click', function(e){

    //if( $(e.target).closest( $('.popup-container .inner-popup-container') ).length === 0 && !document.querySelectorAll('.editable-text') ) {

    if( $(e.target).closest( $('.popup-container .inner-popup-container') ).length === 0 ) {

        $(this).removeClass('display');
        $(this).find('.inner-popup-container').scrollTop(0);
    }

});



$(document).keydown(function(e){

    // Check if escape key is pressed
    if (e.key === "Escape") {

        $('.popup-container').removeClass('display');
        $('.popup-container .inner-popup-container').scrollTop(0);
    }

});


// === End of section to Close Popup Container ===
