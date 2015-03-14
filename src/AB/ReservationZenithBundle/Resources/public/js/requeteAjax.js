/*selection du tarif en fonction de la place*/
var champPlace = $('#reservation_place');
var champPrix = $('#reservation_tarif');
var champSpectacle = $('#reservation_spectacles');
var champHref = $('#href');
var champHrefSeance = $('#hrefSeances');
var champSeance = $('#reservation_seance');
$(document).ready(function(){
champSeance.html(null);
  champPlace.change(function(){
    var plc = champPlace.val();
    var id = champSpectacle.val();
    var unurl = champHref.val();
    unurl = unurl.replace("__place__",plc);
    unurl = unurl.replace("__spectacle__",id);
    $.ajax({
       url : unurl,
       type : 'GET',
       success: function(retour){
        var tarif = JSON.parse(retour);
        champPrix.val(tarif.id);
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("Status: " + textStatus+ "\n"+"error:"+errorThrown); 
       }  
    });
  });

  champSpectacle.change(function(){
    var plc = champPlace.val();
    var id = champSpectacle.val();
    var unurl = "";
    unurl = champHref.val();
    unurl = unurl.replace("__place__",plc);
    unurl = unurl.replace("__spectacle__",id);
    $.ajax({
       url : unurl,
       type : 'GET',
       success: function(retour){
        var tarif = JSON.parse(retour);
        champPrix.val(tarif.id);
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("Aucun tarif associé, mais le spectacle n'est pas gratuit!"); 
          champPrix.val("");
       }  
    });    
    var unurl = champHrefSeance.val();
    unurl = unurl.replace("__spectacle__",id);
    $.ajax({
       url : unurl,
       type : 'GET',
       success: function(retour){
        var seances = JSON.parse(retour);
        for(s in seances){
          var date = seances[s].date.substr(0,10);
          var heure = seances[s].heure.substr(11,12);
          var heure = heure.substr(0,5);
          champSeance.append("<option value='"+seances[s].id+"'>"+date+"   "+heure+"</option>");
        }
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("Aucune séance n'est programmée");
          champSeance.val("");
       }  
    });
  });
});

