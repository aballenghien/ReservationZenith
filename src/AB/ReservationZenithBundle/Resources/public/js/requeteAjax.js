/*selection du tarif en fonction de la place*/
var champPlace = $('#reservation_place');
var champPrix = $('#reservation_tarif');
var champSeance = $('#reservation_seance');

jQuery(document).ready(function() {
    champPlace.change(function(){
        var place='';
        place = champPlace.val();
        seance = champSeance.val();
        $.ajax({
                   type:"POST"
                   url:"../ajax/getTarifWithPlace",
                   data:"place="+place,
                   
                   success: function(retour){
           chamPrix.val(retour);
                   }
                   
               });
    });
});