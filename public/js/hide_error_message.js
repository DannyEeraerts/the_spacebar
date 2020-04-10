const error_messages = document.querySelectorAll('.invalid-feedback');

function hideMessage(){
  this.classList.remove('d-block');
}

error_messages.forEach(message => {
 message.addEventListener("click" ,hideMessage);
});




