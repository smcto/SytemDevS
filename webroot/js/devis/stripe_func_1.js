function readErrors(elements) {
    elements.forEach(function (element, idx) {
        element.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
    });
}

function validateFields(elements) {
    elements.forEach(function (element, idx) {
        $(element).trigger('keyup');
        $(element).trigger('change');
    });
    readErrors(elements);
}

function triggerBrowserValidation(form) {
    // The only way to trigger HTML5 form validation UI is to fake a user submit
    // event.
    var submit = document.createElement('input');
    submit.type = 'submit';
    submit.style.display = 'none';
    form.appendChild(submit);
    submit.click();
    submit.remove();
}

function enableInputs(form) {
    Array.prototype.forEach.call(
        form.querySelectorAll(
            "input[type='text'], input[type='email'], input[type='tel']"
        ),
        function(input) {
            input.removeAttribute('disabled');
        }
    );
}

function disableInputs(form) {
    Array.prototype.forEach.call(
        form.querySelectorAll(
            "input[type='text'], input[type='email'], input[type='tel']"
        ),
        function(input) {
            input.setAttribute('disabled', 'true');
        }
    );
}
