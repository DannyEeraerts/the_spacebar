window.onload = function() {
  const inputField = document.querySelector('#article_form_imageFile');

  function changeLayout(){
    console.log(this.nextSibling.nextSibling)
    this.nextSibling.innerHTML = inputField.files[0].name;
  }

  inputField.addEventListener("change", changeLayout);

};
