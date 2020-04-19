const password_attr = document.querySelector('#inputPassword');
const password_eye = document.querySelector('.password-eye');

function changeEye(){
  if (password_eye.classList[2] === "fa-eye-slash"){
    password_eye.classList.remove("fa-eye-slash");
    password_eye.classList.add("fa-eye");
    password_attr.setAttribute("type", "text");
  } else{
    password_eye.classList.remove("fa-eye");
    password_eye.classList.add("fa-eye-slash");
    password_attr.setAttribute("type", "password");
  }
}

password_eye.addEventListener('click', changeEye);