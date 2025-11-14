// Paiement stripe
// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
var apiKey = $('.stripe-modal').attr('data-client-public');
var stripe = Stripe(apiKey);
var elements = stripe.elements();
// Set up Stripe.js and Elements to use in checkout form

var card = elements.create("card");
// card.mount("#card-element");

var elements = stripe.elements({
    fonts: [{
        cssSrc: 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400',
    }, ],
    locale: 'fr-FR',
});

var elementStyles = {
    base: {
        color: '#2c2b2e',
        fontWeight: 400,
        fontFamily: 'Rubik, Open Sans, Segoe UI, sans-serif',
        fontSize: '14px',
        // fontSmoothing: 'antialiased',

        ':focus': {
            color: '#424770',
        },

        '::placeholder': {
            color: '#525458',
        },

        ':focus::placeholder': {
            color: '#939fab',
        },
    },
    invalid: {
        color: '#f73a5c',
        ':focus': {
            color: '#f62d51',
        },
        '::placeholder': {
            color: '#ff5a78',
        },
    },
};

var elementClasses = {
    focus: 'focus',
    empty: 'empty',
    invalid: 'invalid',
};

var cardNumber = elements.create('cardNumber', {
    style: elementStyles,
    classes: elementClasses,
});
cardNumber.mount('#card-number');

var cardExpiry = elements.create('cardExpiry', {
    style: elementStyles,
    classes: elementClasses,
});
cardExpiry.mount('#card-expiry');

var cardCvc = elements.create('cardCvc', {
    style: elementStyles,
    classes: elementClasses,
});
cardCvc.mount('#card-cvc');

err = readErrors([cardNumber, cardExpiry, cardCvc]);


// Soummetre le form strip
// Listen on the form's 'submit' handler...


var formContainerClassName = 'container-stripe-form';
var formContainer = document.querySelector('.' + formContainerClassName);
var form = formContainer.querySelector('form');
submitForm([cardNumber, cardExpiry, cardCvc], form);


function submitForm(elements, form) {

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        // console.log(validateFields(elements));
        // Trigger HTML5 validation UI on the form if any of the inputs fail
        // validation.
        var plainInputsValid = true;
        Array.prototype.forEach.call(form.querySelectorAll('input'), function(input) {
            if (input.checkValidity && !input.checkValidity()) {
                plainInputsValid = false;
                return;
            } else {
                $('.validate').removeAttr("disabled").removeClass('disabled').text("Valider le paiement")
            }
        });

        $('.cancel-payment').click(function(event) {
            $('.validate').removeAttr("disabled").removeClass('disabled').text("Valider le paiement")
            enableInputs(form);
        });

        if (!plainInputsValid) {
            triggerBrowserValidation(form);
            return;
        } else {
            validateFields([cardCvc, cardExpiry, cardNumber]);
        }

        $('.validate').attr("disabled", "disabled").addClass('disabled').text('En cours de chargement')

        // Disable all inputs.
        disableInputs(form);

        // Gather additional customer data we may have collected in our form.
        var email = $('.email').get(0);
        var additionalData = {
            email: email ? email.value : undefined,
        };

        // console.log(additionalData);
        // return false;

        // Use Stripe.js to create a token. We only need to pass in one Element
        // from the Element group in order to create a token. We can also pass
        // in the additional customer data we collected in our form.
        stripe.createToken(elements[0], additionalData).then(function(result) {
            if (result.token) {
                stripeTokenHandler(result.token);
            } else {
                enableInputs(form);
                $('.validate').removeAttr("disabled").removeClass('disabled').text("Valider le paiement")
            }

            if (result.error) {
                // console.log(result.error);
                $('#card-errors').html(result.error.message);
                // $('#card-errors').text("Votre carte a été refusée, veuillez valider vos coordonnées");
            }
        });

        // Submit the form with the token ID to pass to url server side
        function stripeTokenHandler(token) {

            $('.token_id').remove();

            $("<label>", {'for': 'token_id', 'class': 'd-none'}).text('Token ID').appendTo($(form));
            $('<input>', {'id': 'token_id', 'class': ' form-control', type: 'hidden', name: 'stripeToken', value: token.id }).appendTo($(form));
            $('<input>', {'id': 'email', 'class': ' form-control', type: 'hidden', name: 'email', value: additionalData.email }).appendTo($(form));

            // Vennant formulaire extérieur, si valeur = total_remaining paiement de la totlaité ou du reste
            if ($('input[type="radio"][name="echeance"]').length > 0) {
                $('.echeance').remove();
                $('input[type="radio"][name="echeance"]').each(function(event) {
                    if ($(this).is(':checked')) {
                        $('<input>', {
                            'type' : 'hidden', // text // hidden
                            'class' : 'form-control echeance',
                            'name' : 'echeance',
                            'value': $(this).val(),
                        }).appendTo($(form))
                    }
                });
            }

            form.submit();
        }
    });
}

