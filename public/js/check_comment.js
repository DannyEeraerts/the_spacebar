

const contentInput = document.querySelector("#inputContent");
const contentShow = document.querySelector("#showErrorContent");
const contentText = document.querySelector("#errorTextContent");
const localeData = document.querySelector("#localeLanguage");
const submitButton = document.querySelector("#submitButton");



// const passwordError = document.querySelector("invalid-feedback");

function contentRegexCheck(contentInput) {
  let passwordRegex = /^^(?:(?:^| )\S+ *){8,}$/;
  return (passwordRegex.test(contentInput));
}

/*check passwords on blur*/

function contentVerify() {
  console.log("test");
  let locale = localeData.getAttribute("data-language-type");
  console.log(contentInput);
  if (contentInput.value !== "") {
    if (contentRegexCheck(contentInput.value)) {
      contentText.innerHTML = "";
      contentShow.classList.remove("d-block");
    } else {
      if (locale === "en"){
        contentText.innerHTML = "Comment has no valid format &nbsp;&#x274C";
      }
      else {
        contentText.innerHTML = "Opmerking heeft geen geldig formaat &nbsp;&#x274C";
      }
      contentShow.classList.add("d-block");
    }
  }
  else {
    if (locale === "en") {
      contentText.innerHTML = "Comment is required&nbsp;&#x274C;";
    }
    else {
      contentText.innerHTML = "Opmerking is vereist &nbsp;&#x274C";
    }
    contentShow.classList.add("d-block");
  }
  console.log(contentText);
}

function contentSubmitVerify(e){
  if ((contentText.innerHTML !== "")|(contentInput.value === "")) {
    e.preventDefault();
  }
}

/*add event listeners*/

contentInput.addEventListener('blur', contentVerify, false);
submitButton.addEventListener('click', contentSubmitVerify, false);