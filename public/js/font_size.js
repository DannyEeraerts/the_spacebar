const size = document.querySelector("#f_size");
let percent = 1;

function changeFontSize(){

  switch (percent) {
    case 0:
      document.body.style.fontSize = "85%";
      percent = 1;
      console.log(percent);
      break;
    case 1:
      document.body.style.fontSize = "100%";
      percent = 2;
      console.log(percent);
      break;
    case 2:
      document.body.style.fontSize = "125%";
      percent = 0;
      break;
  }
}

size.addEventListener("click", changeFontSize);