$(document).ready(function(){
    $('.menu-toggle').click(function(){
        $('nav').toggleClass('active')
    })
})

// Local Time API
(function(d, eId){
    var js, gjs = d.getElementById(eId);
    js = d.createElement('script'); js.id = 'gwt-pst-jsdk';
    js.src = "//gwhs.i.gov.ph/pst/gwtpst.js?"+new Date().getTime();
    gjs.parentNode.insertBefore(js, gjs);
}(document, 'gwt-pst'));
var gwtpstReady = function(){
    new gwtpstTime('pst-time');
}


function searchTrans() {
    var input, filter, cards, cardContainer, h3, title, i;
    input = document.getElementById("filter");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("card-lists");
    cards = cardContainer.getElementsByClassName("card");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card_body h3.card-title");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
  }
  