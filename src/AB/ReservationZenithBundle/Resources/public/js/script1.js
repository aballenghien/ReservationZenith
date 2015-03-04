/*Ajout et suppression des seances et des tarifs dans les pages spectacle/ajouter et spectacle/modifier */

var collectionHolderSeances = $('#seances');
var collectionHolderTarifs = $('#tarifs');

var $addSeanceLink = $('<a href="#" class="add_seance_link">Ajouter une Seance</a>');
var $newLinkDivSeance = $('<div id="add_seance"></div>').append($addSeanceLink);

var $addTarifLink = $('<a href="#" class="add_tarif_link">Ajouter un Tarif</a>');
var $newLinkDivTarif = $('<div id="add_tarif"></div>').append($addTarifLink);



jQuery(document).ready(function() {
    collectionHolderSeances.append($newLinkDivSeance);
    collectionHolderTarifs.append($newLinkDivTarif);
    $addSeanceLink.on('click', function(e) {
        e.preventDefault();
        addForm(collectionHolderSeances, $newLinkDivSeance);
    });
    $addTarifLink.on('click', function(e) {
        e.preventDefault();
        addForm(collectionHolderTarifs, $newLinkDivTarif);
    });
    $( "div[id='seance']" ).each(function() {
        addTagFormDeleteLink($(this));
    });
    $( "div[id='tarif']" ).each(function() {
        addTagFormDeleteLink($(this));
    });

});

//ajouter des formulaire
function addForm(collectionHolder, $newLinkDiv) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g,collectionHolder.children().length);

    
    var $newFormDiv = $('<div></div>').append(newForm);
    $newLinkDiv.before($newFormDiv);
    addTagFormDeleteLink($newFormDiv);
}

//supprimer des formulaires 
function addTagFormDeleteLink($formDiv) {
    var $removeFormA = $('<a href="#">Supprimer</a>');
    $formDiv.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de tag
        $formDiv.remove();
    });
}

/*selection du tarif en fonction de la place*/
var champPlace = $('#ab_reservationzenithbundle_reservation_place');
var champPrix = $('#ab_reservationzenithbundle_reservation_tarif');

/*jQuery(document).ready(function() {
    champPlace.change(function(){
        var value='';
        value = champPlace.val();
        $.ajax({
                   type:"POST"
                   url:"../pageAjax/afficherTarif.php",
                   data:"value="+value,
                   
                   success: function(retour){
           chamPrix.val(retour);
                   }
                   
               });
    });
});*/
