const heart = document.querySelector(".js-like-article");
const count = document.querySelector(".js-like-article-count");
const title = document.querySelector(".title");


function toggleClass(){

  let result = this.classList.contains("fa-heart-o");
  let path = heart.dataset.link;
  if (result) {
    this.classList.remove("fa-heart-o");
    this.classList.add("fa-heart");
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/news/'+ path +'/heart', true);
    xhr.onload=function(){
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

