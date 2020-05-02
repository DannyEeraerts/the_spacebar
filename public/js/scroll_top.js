window.onload = function() {
  const buttonToTop = document.querySelector("#return-to-top");

  // When the user scrolls down 250px from the top of the document, show the button
  window.onscroll = function () {
    scrollFunction()
  };

  function scrollFunction() {

      if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
        buttonToTop.style.display = "block";
      } else {
        buttonToTop.style.display = "none";
      }
    }


};
