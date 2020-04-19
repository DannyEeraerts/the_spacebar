const password_eye = document.querySelectorAll('.password-eye');

function changeEye(){
  if (this.classList[2] === "fa-eye-slash"){
      this.classList.remove("fa-eye-slash");
      this.classList.add("fa-eye");
    this.parentElement.parentElement.parentElement.firstElementChild.setAttribute("type", "text");
  } else{
      this.classList.remove("fa-eye");
      this.classList.add("fa-eye-slash");
    this.parentElement.parentElement.parentElement.firstElementChild.setAttribute("type", "password");
  }
}

password_eye.forEach (eye => {
  eye.addEventListener('click', changeEye);
});
