document.querySelectorAll('#remove-phone').forEach(function(btn){
    btn.addEventListener('click',removeInput);
})
document.querySelectorAll('#remove-email').forEach(function(btn){
    btn.addEventListener('click',removeInput);
})
if(document.querySelector('#add-contact-form') !== null) {
    document.querySelector('#add-contact-form').addEventListener('submit',setPrimary)
} else if (document.querySelector('#update-contact-form') !== null) {
    document.querySelector('#update-contact-form').addEventListener('submit',setPrimary)
}
function setPrimary(evt) {
    document.getElementsByName('primaryEmail').forEach(function(radioButton){
        if(radioButton.checked){
            console.log(radioButton.parentNode.parentNode.children[1].children[0].value);
            document.getElementsByName('primaryEmailId')[0].value = radioButton.parentNode.parentNode.children[1].children[0].value;
        }
    })
    document.getElementsByName('primaryPhone').forEach(function(radioButton){
        if(radioButton.checked){
            console.log(radioButton.parentNode.parentNode.children[1].children[0].value);
            document.getElementsByName('primaryPhoneNumber')[0].value = radioButton.parentNode.parentNode.children[1].children[0].value;
        }
    })
}
let emailCount = 1;
let phoneCount = 1;
document.querySelector('#add-phone').addEventListener('click',function(evt){
    evt.stopPropagation();
    addPhone('');
});
document.querySelector('#add-email').addEventListener('click',function(evt){
    evt.stopPropagation();
    addEmail('');
});
function addEmail(radioStatus,value = '',error){
    let emailName = 'email[]';
    let emailText = 'Email'
    // document.querySelector('#email-column').appendChild(addInput('email','email',emailName,'text',emailText,value,error,radioStatus));
    let emailColumn = document.querySelector('#email-column');
    let newEmail = addInput('email','email',emailName,'text',emailText,value,error,radioStatus);
    emailColumn.insertBefore(newEmail,emailColumn.children['add-email']);
    if(emailCount == 1) {
        emailColumn.children[0].children['remove-btn'].classList.remove('disabled')
    }
    emailCount++;
}

function addPhone(radioStatus,value = '',error){
    let phoneName = 'phone[]';
    let phoneText = 'Phone'
    // document.querySelector('#phone-column').appendChild(addInput('phone','phone',phoneName,'tel',phoneText,value,error,radioStatus));
    let phoneColumn = document.querySelector('#phone-column');
    let newPhone = addInput('phone','phone',phoneName,'tel',phoneText,value,error,radioStatus);
    phoneColumn.insertBefore(newPhone,phoneColumn.children['add-phone']);
    if(phoneCount == 1) {
        phoneColumn.children[0].children['remove-btn'].classList.remove('disabled')
    }
    phoneCount ++;
}
function addInput(inputFor,id, name, type,labelText,value,errorMessage,radioStatus='unchecked',radioValue=null)
{
    const flexDiv = document.createElement('div');
    flexDiv.classList.add('w-100','flex', 'f-align-center','f-space-around');

    const radioLabel = document.createElement('label');

    const radioInput = document.createElement('input');
    radioInput.className = 'with-gap';

    if(inputFor == 'email') {
        radioInput.name = 'primaryEmail';
        radioInput.value = emailCount;
    } else {
        radioInput.name= 'primaryPhone';
        radioInput.value = phoneCount;
    }
    radioInput.type = 'radio';
    if(radioStatus == 'checked'){
        radioInput.setAttribute('checked','');
    } else {
        radioInput.setAttribute('unchecked','');
    }

    const radioSpan = document.createElement('span');
    radioSpan.title = "Mark as primary";

    radioLabel.appendChild(radioInput);
    radioLabel.appendChild(radioSpan);

    document.createElement('label')

    const inputFieldDiv = document.createElement('div');
    inputFieldDiv.classList.add('input-field','w-85')

    const input = document.createElement('input');
    input.setAttribute('id',id);
    input.setAttribute('name',name);
    input.setAttribute('type',type);
    input.setAttribute('value',value);

    const inputLabel = document.createElement('label');
    inputLabel.setAttribute('for',inputFor);
    inputLabel.innerText = labelText;

    const errorDiv = document.createElement('div');
    errorDiv.className = inputFor + '_error';
    errorDiv.classList.add('red-text','text-darken-1');
    errorDiv.textContent = errorMessage;

    inputFieldDiv.appendChild(input);
    inputFieldDiv.appendChild(inputLabel);
    inputFieldDiv.appendChild(errorDiv);

    const removeBtn = document.createElement('a');
    removeBtn.classList.add('btn-floating','waves-effect','btn-small','red');
    removeBtn.id = 'remove-btn'

    const icon = document.createElement('i');
    icon.classList.add('material-icons','remove');
    icon.innerText = 'remove';
    icon.addEventListener('click',removeInput);

    removeBtn.appendChild(icon);
    flexDiv.appendChild(radioLabel);
    flexDiv.appendChild(inputFieldDiv);
    flexDiv.appendChild(removeBtn);

    return flexDiv;
}
function removeInput(evt)
{
    let parentColumn = evt.target.parentNode.parentNode.parentNode;
    if(parentColumn.id === 'email-column') {
        emailCount --;
        if(emailCount == 1) {
            parentColumn.children[0].children['remove-btn'].classList.add('disabled');
        }
    } else if(parentColumn.id === 'phone-column') {
        phoneCount--;
        if(phoneCount == 1) {
            parentColumn.children[0].children['remove-btn'].classList.add('disabled');
        }
    }
    evt.target.parentNode.parentNode.remove();
}
