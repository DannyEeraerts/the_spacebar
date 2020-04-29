const passwordInput = document.querySelector("#inputPassword");
const passwordShow = document.querySelector("#showErrorPassword");
const passwordText = document.querySelector("#errorTextPassword");
const localeData = document.querySelector("#header");
const passwordRepeatInput = document.querySelector("#inputRepeatPassword");
const passwordRepeatShow = document.querySelector("#showErrorRepeatPassword");
const passwordRepeatText = document.querySelector("#errorTextRepeatPassword");

let locale = localeData.getAttribute("data-language-type");
console.log(locale);
// const passwordError = document.querySelector("invalid-feedback");
const submitButton = document.querySelector("#submitButton");

function PasswordRegexCheck(passwordInput) {
  let passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[a-z]).{8,13}$/;
  return (passwordRegex.test(passwordInput));
}

/*check passwords on blur*/

function passwordVerify(locale) {
  console.log(locale);
  if (this.value !== "") {
    if (PasswordRegexCheck(this.value)) {
      passwordText.innerHTML = "";
      passwordShow.classList.remove("d-block");
    } else {
      if (locale === "en"){
        passwordText.innerHTML = "Password has no valid format &nbsp;&#x274C";
      }
      else {
        passwordText.innerHTML = "Paswoord heeft geen geldig formaat &nbsp;&#x274C";
      }

      passwordShow.classList.add("d-block");
    }
  }
  else {
    if (locale === "en") {
      passwordText.innerHTML = "Password is required&nbsp;&#x274C;";
    }
    else {
      passwordText.innerHTML = "Paswoord is vereist &nbsp;&#x274C";
    }
      passwordShow.classList.add("d-block");
  }
}

function passwordRepeatVerify(locale) {
  if (this.value !== "") {
    if (PasswordRegexCheck(this.value)) {
      passwordRepeatText.innerHTML = "";
      passwordRepeatShow.classList.remove("d-block");

    } else {
      if (locale === "en") {
        passwordRepeatText.innerHTML = "Password has no valid format&nbsp;&#x274C";
      }
      else {
        passwordRepeatText.innerHTML = "Paswoord heeft geen geldig format&nbsp;&#x274C";
      }
      passwordRepeatShow.classList.add("d-block");
    }
  }
  else {
    if (locale === "en") {
      passwordText.innerHTML = "Password is required&nbsp;&#x274C;";
    }
    else {
      passwordText.innerHTML = "Paswoord is vereist &nbsp;&#x274C";
    }
    passwordRepeatShow.classList.add("d-block");
  }
  if (passwordInput.value === passwordRepeatInput.value){
    passwordRepeatText.innerHTML = "";
    passwordRepeatShow.classList.remove("d-block");
  } else {
    if (locale === "en") {
      passwordRepeatText.innerHTML = "Passwords doesn't match&nbsp;&#x274C";
    }
    else {
      passwordRepeatText.innerHTML = "Paswoorden komen niet overeen &nbsp;&#x274C";
    }
    passwordRepeatShow.classList.add("d-block");
  }
}

function CheckAll(locale) {
  passwordVerify(locale);
  passwordRepeatVerify(locale);
  if ((passwordText.textContent !== "") || (passwordRepeatText.textContent !== "")) {
    event.preventDefault();
  }
}


/*add event listenersr*/

passwordInput.addEventListener('blur',passwordVerify(locale));
passwordRepeatInput.addEventListener('blur',passwordRepeatVerify(locale));
submitButton.addEventListener('click', CheckAll(locale));
