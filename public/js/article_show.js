let heart = document.querySelector(".js-like-article");
let count = document.querySelector(".js-like-article-count");

function toggleClass(){
  let result = this.classList.contains("fa-heart-o");
  if (result) {
    this.classList.remove("fa-heart-o");
    this.classList.add("fa-heart");
    count.textContent = "test";
  }
  else{
    this.classList.remove("fa-heart");
    this.classList.add("fa-heart-o");
    count.textContent = "5";
  }
}

heart.addEventListener("click", toggleClass);