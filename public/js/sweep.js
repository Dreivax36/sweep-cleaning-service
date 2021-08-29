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

