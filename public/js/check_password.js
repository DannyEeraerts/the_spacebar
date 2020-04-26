const passwordInput = document.querySelector("#inputPassword");
const passwordShow = document.querySelector("#showErrorPassword");
const passwordText = document.querySelector("#errorTextPassword");
const passwordRepeatInput = document.querySelector("#inputRepeatPassword");
const passwordRepeatShow = document.querySelector("#showErrorRepeatPassword");
const passwordRepeatText = document.querySelector("#errorTextRepeatPassword");


const passwordError = document.querySelector("invalid-feedback");
const submitButton = document.querySelector("#submitButton");

function PasswordRegexCheck(passwordInput) {
  let passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,13}$/;
  return (passwordRegex.test(passwordInput));
}

/*check passwords on blur*/

function passwordVerify() {
  if (this.value !== "") {
    if (PasswordRegexCheck(this.value)) {
      passwordText.innerHTML = "";
      passwordShow.classList.remove("d-block");
    } else {
      passwordText.innerHTML = "Password has no valid format &nbsp;&#x274C";
      passwordShow.classList.add("d-block");
    }
  }
  else {
    passwordText.innerHTML = "Password is required&nbsp;&#x274C;";
    passwordShow.classList.add("d-block");
  }
}

function passwordRepeatVerify() {
  if (this.value !== "") {
    if (PasswordRegexCheck(this.value)) {
      passwordRepeatText.innerHTML = "";
      passwordRepeatShow.classList.remove("d-block");

    } else {
      passwordRepeatText.innerHTML = "Password has no valid format&nbsp;&#x274C";
      passwordRepeatShow.classList.add("d-block");
    }
  }
  else {
    passwordRepeatText.innerHTML = "Password is requiredt&nbsp;&#x274C;";
    passwordRepeatShow.classList.add("d-block");
  }
  console.log(passwordInput.value);
  console.log(passwordRepeatInput.value);
  if (passwordInput.value === passwordRepeatInput.value){
    passwordRepeatText.innerHTML = "";
    passwordRepeatShow.classList.remove("d-block");
  } else {
    console.log(passwordInput.value);
    passwordRepeatText.innerHTML = "Passwords doesn't match&nbsp;&#x274C";
    passwordRepeatShow.classList.add("d-block");
  }
}

/*function CheckAll(){
  passwordVerify();
  passwordVerify2();
  if ((passworderrorText.textContent !== "") || (passworderrorText2.textContent !== "") || (passwordCompareErrorText.textContent !== "")) {
    event.preventDefault();
  }
}*/

/*add event listenersr*/

passwordInput.addEventListener('blur',passwordVerify);
passwordRepeatInput.addEventListener('blur',passwordRepeatVerify);




/*logbutton.addEventListener('click', CheckAll);*/
