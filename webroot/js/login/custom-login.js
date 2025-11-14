 $(document).ready(function(){

    // === Login section ===

     // Declare and initialize global variable
     let errorMessage = $('.login-wrapper .inner-login-wrapper .login-detail-wrapper .error-message');

     $(document).on('input', '.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .inner-data-wrapper input', function(){

        if( $(this).val() ) {
            $(this).parents('.inner-data-wrapper').addClass('display-label');
        } else {

            $(this).parents('.inner-data-wrapper').removeClass('display-label');
        }

         errorMessage.text('');

    });

     if( $('.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .username-data-wrapper input').val() ) {
         $('.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .username-data-wrapper').addClass('display-label');
     }

     if( $('.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .password-data-wrapper input').val() ) {
         $('.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .password-data-wrapper').addClass('display-label');
     }

    $(document).on('click', '.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .password-data-wrapper .password-text-indicator', function(){

        if( $(this).hasClass('fa-eye') == $(this).hasClass('display') ) {
            changePasswordType($(this), '.fa-eye-slash');
        } else {
            changePasswordType($(this), '.fa-eye');
        }

    });

    function changePasswordType(passwordTextIndicator, indicatorToDisplay){

        passwordTextIndicator.removeClass('display');
        passwordTextIndicator.parents('.password-data-wrapper').find(indicatorToDisplay).addClass('display');

        if( indicatorToDisplay == '.fa-eye-slash' ) {
            passwordTextIndicator.parents('.password-data-wrapper').find('input').attr('type', 'text');
        } else {
            passwordTextIndicator.parents('.password-data-wrapper').find('input').attr('type', 'password');
        }
    }

     $('body').delegate('.login-wrapper .inner-login-wrapper .login-detail-wrapper .bottom-detail-wrapper .login-button', 'click', function(e){

        pusleCircle(e);

        if( !$('.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .username-data-wrapper input').val() ) {

            errorMessage.text('Merci de renseigner un identifiant');
            return false;
        }

        if( !$('.login-wrapper .inner-login-wrapper .login-detail-wrapper .data-wrapper .password-data-wrapper input').val() ) {

            errorMessage.text('Merci de renseigner un mot de passe');
            return false;
        }

    });

     function pusleCircle(event) {

         let loginBtn = document.querySelector('.login-wrapper .inner-login-wrapper .login-detail-wrapper .bottom-detail-wrapper .login-button');

         var leftPosition = event.pageX - loginBtn.offsetLeft;
         var topPosition = event.pageY - loginBtn.offsetTop;

         let circle = document.createElement('div');
         circle.setAttribute('class', 'circle-pulse');
         circle.style.left = leftPosition + 'px';
         circle.style.top = topPosition + 'px';

         loginBtn.appendChild(circle);

         setTimeout(function(){
             circle.remove();
         }, 1000);
     }

     // === End of Login section ===

 });
