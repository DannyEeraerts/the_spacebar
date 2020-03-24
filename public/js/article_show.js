const heart = document.querySelector(".js-like-article");
const count = document.querySelector(".js-like-article-count");
const title = document.querySelector(".title");

function toggleClass(){

  console.log("in function");

  console.log(this.classList.contains("fa-heart-o"));
  let result = this.classList.contains("fa-heart-o");
  console.log(result);
  if (result) {
    this.classList.remove("fa-heart-o");
    this.classList.add("fa-heart");
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/news/'+ title +'/heart', true);
    xhr.onload=function(){
      console.log(xhr.status);
      if(xhr.status === 200){
        let response = xhr.responseText;
        let object = JSON.parse(response);
        count.textContent = object.hearts;
      }
    };
    xhr.send();
  }
  else{
    this.classList.remove("fa-heart");
    this.classList.add("fa-heart-o");
  }
}

heart.addEventListener("click", toggleClass);
