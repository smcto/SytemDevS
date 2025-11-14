$(document).ready(function(){

    const baseUrl = $('#id_baseUrl').attr('value');

    $('body').append('<div class="status-gif-img-wrapper"><img alt="gif" /></div>');

    //var gifImages = ['gif1.gif', 'gif2.gif', 'gif3.gif', 'gif4.gif', 'gif5.gif', 'gif6.gif', 'gif7.gif', 'gif8.gif', 'gif9.gif', 'gif10.gif', 'gif11.gif', 'gif12.gif', 'gif13.gif', 'gif14.gif', 'gif15.gif'];

    var gifImages = [];

    const folderPath = baseUrl + '/img/status-gif/';

    //var timerId = 0;

    $.ajax({
        url: baseUrl + 'fr/devis/getGifImages/',
        success: function(data){
            if(data.length) {
                gifImages = JSON.parse(data);
            }
        }
    });


    window.displayGifImage = function(){

        //clearTimeout(timerId);

        var randomNumber = Math.floor(Math.random() * gifImages.length);

        $('.status-gif-img-wrapper img').attr( 'src', folderPath + gifImages[randomNumber] );

        $('body').addClass('no-overflow');

        /*

        timerId = setTimeout(function(){
            // Call function to Hide gif image
            hideGifImage();
        }, 2500);

        */

        $('.status-gif-img-wrapper').addClass('display');
    }


    // === Function to Hide gif image ===

    function hideGifImage() {

        $('.status-gif-img-wrapper').removeClass('display');
        $('.status-gif-img-wrapper img').attr('src', '');
        $('body').removeClass('no-overflow');
    }

    // === End of Function to Hide gif image ===


    // === Hide gif image when clicking on status gif img wrapper ===

    $(document).on('click', '.status-gif-img-wrapper', function(e){

        // Call function to Hide gif image
        hideGifImage();

    });

    // === End of section to Hide gif image when clicking on status gif img wrapper ===



    $(document).on('click', '.gif-button-wrapper .gif-button', function(){

        displayGifImage();
    });


});
