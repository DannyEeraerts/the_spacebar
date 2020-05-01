
  const cookieContainer = document.querySelector("#cookie_container");
  const cookieAgreeButton = document.querySelector(".cookie-agree-btn");
  const cookieDisAgreeButton = document.querySelector(".cookie-disagree-button");

  function testCookieExist() {
    let myCookie = document.cookie;
    if (myCookie) {
      cookieContainer.classList.add("hide");
    }
    else {
      cookieContainer.classList.remove("hide");
    }
  }

  function placeCookie() {
    document.cookie = "cookieBannerDisplayed=true;max-age=360";
    cookieContainer.classList.add("hide");
  }

  function toggleClassDisAgree() {
    cookieContainer.classList.add("hide");
  }

  cookieAgreeButton.addEventListener("click", placeCookie);
  cookieDisAgreeButton.addEventListener("click", toggleClassDisAgree);
  window.addEventListener("load",testCookieExist);