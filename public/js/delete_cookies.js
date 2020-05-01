const deleteCookieButton = document.querySelector("#cookielawinfo-cookie-delete");

function deleteCookie() {
  document.cookie = "cookieBannerDisplayed=true; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  console.log("cookie is verwijderd");
}

deleteCookieButton.addEventListener("click", deleteCookie);
