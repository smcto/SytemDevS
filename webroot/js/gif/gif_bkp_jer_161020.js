$(document).ready(function(){

    $('body').append('<div class="status-gif-img-wrapper"><img alt="gif" /></div>');

    var gifImages = ['gif1.gif', 'gif2.gif', 'gif3.gif', 'gif4.gif', 'gif5.gif', 'gif6.gif', 'gif7.gif', 'gif8.gif', 'gif9.gif', 'gif10.gif', 'gif11.gif', 'gif12.gif', 'gif13.gif', 'gif14.gif', 'gif15.gif'];

    const folderPath = '/img/status-gif/';

    //const folderPath = '/crm-selfizee/img/status-gif/gif1.gif';

    var timerId = 0;

    $(document).on('click', '.gif-button-wrapper .gif-button', function(){

        clearTimeout(timerId);

        var randomNumber = Math.floor(Math.random() * gifImages.length);

        //var randomNumber = Math.floor(Math.random() * ( gifImages.length - 1 ) );

        $('.status-gif-img-wrapper img').attr( 'src', folderPath + gifImages[randomNumber] );

        //$('.status-gif-img-wrapper').addClass('display');

        timerId = setTimeout(function(){
            $('.status-gif-img-wrapper').removeClass('display');
            $('.status-gif-img-wrapper img').attr('src', '');
        }, 2500);

        $('.status-gif-img-wrapper').addClass('display');

    });


});
