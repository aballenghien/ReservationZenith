/*selection du tarif en fonction de la place*/
var champPlace = $('#reservation_place');
var champSpectacle = $('#reservation_spectacles');
var champHref = $('#href');
var champHrefSeance = $('#hrefSeances');
var champSeance = $('#reservation_seance');
var champPrix = $('#reservation_tarif');
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
        champPrix.val(tarif.prix);
       }  
    });
  });
  champSpectacle.click(function(){
    champSeance.html(null);
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
        champPrix.val(tarif.prix)
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
       }  
    });
  });
  champSpectacle.change(function(){    
    champSeance.html(null);
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
        champPrix.val(tarif.prix)
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
          champSeance.append("<option value='"+seances[s].id+"' selected='true'>"+date+"   "+heure+"</option>");
        }
       }
    });
  });
});

