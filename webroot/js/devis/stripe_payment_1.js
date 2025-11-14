// A reference to Stripe.js
var stripe;

var orderData = {
    items: [{
        id: "photo-subscription"
    }],
    currency: "usd"
};

// Disable the button until we have Stripe set up on the page
document.querySelector("button").disabled = true;

var baseUrl = $('body').attr('base-url');

fetch(baseUrl+"exchanger/visa/createPaymentIntent", {

    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify(orderData)

}).then(function(result) {

    return result.json();

}).then(function(data) {

    return setupElements(data);

}).then(function({
    stripe,
    card,
    clientSecret
}) {
    document.querySelector("button").disabled = false;
    // Handle form submission.
    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        // Initiate payment when the submit button is clicked
        pay(stripe, card, clientSecret);
    });
});

// Set up Stripe.js and Elements to use in checkout form
var setupElements = function(data) {

    stripe = Stripe(data.publishableKey);
    var elements = stripe.elements();
    // Set up Stripe.js and Elements to use in checkout form

    var card = elements.create("card");
    // card.mount("#card-element");

    var elements = stripe.elements({
        fonts: [{
            cssSrc: 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400',
        }, ],
        locale: 'en-EN',
    });

    var elementStyles = {
        base: {
            color: '#fff',
            fontWeight: 400,
            fontFamily: 'Rubik, Open Sans, Segoe UI, sans-serif',
            fontSize: '15px',
            // fontSmoothing: 'antialiased',

            ':focus': {
                color: '#e2eeff',
            },

            '::placeholder': {
                color: '#939faa',
            },

            ':focus::placeholder': {
                color: '#e2eeff',
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

    var card = elements.create('cardNumber', {
        style: elementStyles,
        classes: elementClasses,
    });
    card.mount('#card-number');

    var card = elements.create('cardExpiry', {
        style: elementStyles,
        classes: elementClasses,
    });
    card.mount('#card-expiry');

    var card = elements.create('cardCvc', {
        style: elementStyles,
        classes: elementClasses,
    });
    card.mount('#card-cvc');

    return {
        stripe: stripe,
        card: card,
        clientSecret: data.clientSecret
    };
};

/*
 * Calls stripe.confirmCardPayment which creates a pop-up modal to
 * prompt the user to enter extra authentication details without leaving your page
 */
var pay = function(stripe, card, clientSecret) {
    changeLoadingState(true);

    // Initiate the payment.
    // If authentication is required, confirmCardPayment will automatically display a modal
    stripe
    .confirmCardPayment(clientSecret, {
        payment_method: {
            card: card,
            billing_details: {
                name: $('#nom').val()+' '+$('#prenom').val(),
                email: $('#email').val(),
                phone: $('#phone').val()
            }
        }
    })
    .then(function(result) {
        if (result.error) {
            // Show error to your customer
            showError(result.error.message);
        } else {
            // The payment has been processed!
            orderComplete(clientSecret);
        }
    });
};

/* ------- Post-payment helpers ------- */

/* Shows a success / error message when the payment is complete */
var orderComplete = function(clientSecret) {
    // Just for the purpose of the sample, show the PaymentIntent response object
    stripe.retrievePaymentIntent(clientSecret).then(function(result) {
        var paymentIntent = result.paymentIntent;
        var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

        // message completed + redirection
        // $('.sr-result').removeClass('d-none').html("<pre>"+paymentIntentJson+"</pre>");
        $('.sr-result').removeClass('d-none').html('<p class="text-success">Votre paiement a été fait avec succès</p>');
        changeLoadingState(false);
        window.location = $('[name="success_url"]').val();
    });
};


// Show a spinner on payment submission
validateText = $('.validate').text();
var changeLoadingState = function(isLoading) {
    if (isLoading) {
        $('.validate').attr('disabled', 'disabled').text('Chargement en cours');
    } else {
        $('.validate').removeAttr('disabled')
        $('.validate').text(validateText);
        // loading finished
    }
};

var showError = function(errorMsgText) {
    changeLoadingState(false);
    $('#card-errors').text(errorMsgText);
};