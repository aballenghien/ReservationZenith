/*selection du tarif en fonction de la place*/
var champPlace = $('#reservation_place');
var champPrix = $('#reservation_tarif');
var champSpectacle = $('#reservation_spectacles');
var champHref = $('#href');

$(document).ready(function(){  
  champPlace.change(function(){
    var plc = champPlace.val();
    var id = champSpectacle.val();
    var unurl = champHref.val();
    unurl = unurl.replace("__place__",plc);
    unurl = unurl.replace("__spectacle__",id);
    $.ajax({
       url : unurl,
       type : 'POST',
       success: function(retour){
        alert(retour);
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("Status: " + textStatus); 
       }  
    });
  });
});
