

var prova =1;
$(document).ready(function() {
  //apre il menù con un click
  $("#expand").click(function(){
    if(prova == 1){
      $("#menu").animate({height:"200px"},1000);
	    $( this ).addClass( "vertical-flip" );
      prova = 0;
    } else{
      $("#menu").animate({height:"50px"},1000);
	    $( this ).removeClass( "vertical-flip" );
	    prova = 1;
    }
  });
  //apre il menù con lo swipe
 /* $("#expand").swipe({
    swipe:function(event, direction, distance, duration, fingerCount){
      if (direction == "down") {
        $("#menu").animate({height:"200px"},1000);
        $( "#expand" ).addClass( "vertical-flip" );
      } else if (direction == "up"){
        $("#menu").animate({height:"50px"},1000);
        $( "#expand" ).removeClass( "vertical-flip" );
      }
    }
  });*/

  //blocca lo swipe a sinistra sulla scheda sinistra aperta
/*  $(".snap-drawer-left").swipe({
    swipe:function(event, direction, distance, duration, fingerCount){
      if (direction == "left") {
        event.preventDefault();
      }
    }
  });
*/
  //apre scheda sinistra
  $("#open-left").click(function(){
    snapper.open('left');
  });

});

/*
var snapper = new Snap({
	element: document.getElementById('content'),
	   
});   */

     
