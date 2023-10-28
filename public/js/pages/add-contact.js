let updateForm = document.querySelector('#update-contact-form');
let addForm = document.querySelector('#add-contact-form');
let form;
if(addForm !== null) {
    addForm.addEventListener('submit',validateForm);
    form = addForm;
} else if (updateForm !== null) {
    updateForm.addEventListener('submit',validateForm);
    form = updateForm;
}
$(function() {
    $('.datepicker').datepicker({
        minDate: new Date(1900, 1, 1),
        maxDate: new Date(),
        yearRange: 25
    });

    $(form).validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            telephone: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            birthdate: {
                required: true
            },
            address: {
                required: true,
                minlength: 5
            },
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
});

function validateForm(evt) {
    // evt.preventDefault();
    document.getElementById('alerts').innerHTML = '';
    if(!validateEmail(document.querySelectorAll('#email'))) {
        evt.preventDefault();
    }
    if(!validatePhone(document.querySelectorAll('#phone'))) {
        evt.preventDefault();
    }
}

function validateEmail(emails) {
    let status = true;

    if(document.querySelectorAll('input[name=primaryEmail]:checked').length < 1) {
        const alert = ` <div class="materialert danger">
                            Please select an email id as primary
                            <button type="button" class="close-alert">×</button>
                        </div>`
         document.getElementById('alerts').innerHTML+= alert;
         status = false;
    }
    let regex = new RegExp('^[A-Za-z_]([\.A-Za-z0-9+-_]+)*@([A-Za-z_]([A-Za-z0-9-])*)(\.[A-Za-z0-9-]+)*(\.[A-Za-z0-9]{2,}$)');

    emails = Array.from(emails);
    emailValues = emails.map( (element) => {
        element.nextElementSibling.nextElementSibling.innerText = "";
        return element.value;
    });

    emails.forEach(function(email, index, emails) {

    // To check if the field is empty
        if(email.value === '') {
            email.nextElementSibling.nextElementSibling.innerText = "The email id field is required";
            status = false;
        } else if(! regex.test(email.value)) {
            email.nextElementSibling.nextElementSibling.innerText = "It must be a valid email address";
            status = false;
        } else {
             // To check for duplicate values for email
            let duplicateValueIndex = emailValues.indexOf(email.value,index+1);
            if(duplicateValueIndex !== index && duplicateValueIndex !== -1){
                (emails[duplicateValueIndex]).nextElementSibling.nextElementSibling.innerText = "The email id field has duplicate values";
                email.nextElementSibling.nextElementSibling.innerText = "The email id field has duplicate values";
                status = false;
            }
        }
    });
    return status;
}

function validatePhone(phoneNumbers) {
    let status = true;
    // To check if primary phone is selected
    if(document.querySelectorAll('input[name=primaryPhone]:checked').length < 1) {
        const alert = ` <div class="materialert danger">
                            Please select a phone number as primary
                            <button type="button" class="close-alert">×</button>
                        </div>`
         document.getElementById('alerts').innerHTML += alert;
         status = false;
    }
    let regex = new RegExp('^[6-9]\\d{9}');

    phoneNumbers = Array.from(phoneNumbers);
    phoneValues = phoneNumbers.map( (element) => {
        element.nextElementSibling.nextElementSibling.innerText = "";
        return element.value;
    });

    phoneNumbers.forEach(function(phone, index, phoneNumbers) {
    // To check if the field is empty
        if(phone.value === '') {
            phone.nextElementSibling.nextElementSibling.innerText = "The phone number field is required";
            status = false;
        } else if(! regex.test(phone.value.trim())) {
            phone.nextElementSibling.nextElementSibling.innerText = "It must be a valid phone number";
            status = false;
        } else {
            // To check for duplicate values for phone
            let duplicateValueIndex = phoneValues.indexOf(phone.value,index+1);
            if(duplicateValueIndex !== index && duplicateValueIndex !== -1){
                (phoneNumbers[duplicateValueIndex]).nextElementSibling.nextElementSibling.innerText = "The phone number has duplicate values";
                phone.nextElementSibling.nextElementSibling.innerText = "The phone number field has duplicate values";
                status = false;
            }
        }
    });
    return status;
}
