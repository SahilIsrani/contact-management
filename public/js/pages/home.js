$(function() {
    $(".dropdown-trigger").dropdown();
    $('.modal').modal();
    $(".close-alert").click(function() {
        $(this).parent().fadeOut(500);
    });
});
document.querySelectorAll('.deleteBtn').forEach(function(btn){
    btn.addEventListener('click',addDeleteFromAction);
})
document.querySelectorAll('.remove-input').forEach(function(btn){
    btn.addEventListener('click',removeInput);
})
function addDeleteFromAction(evt){
    console.log("hello");
     let contactID = evt.target.dataset.contactId;
     let URL = `/contacts/${contactID}`;
     document.getElementById('deleteForm').setAttribute('action',URL);
}
