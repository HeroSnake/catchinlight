$(document).ready(function() {
    var orderPicture = [];
    var deletedPictures = [];
    var elementClick;
    var columns = 1200 / document.getElementById('colonne').value;
    console.log(columns);
    // external js: packery.pkgd.js, draggabilly.pkgd.js
    var pckry = new Packery( '.grid', {
        itemSelector: '.grid-item',
        columnWidth: columns
    });
    pckry.getItemElements().forEach( function( itemElem ) {
        var draggie = new Draggabilly( itemElem );
        pckry.bindDraggabillyEvents( draggie );
    });

    // ON DROP
    pckry.on( 'dragItemPositioned', () => {
        orderItems();
    });

    orderItems = function() {
        var itemElems = pckry.getItemElements();
        orderPicture = [];
        $(itemElems).each(function(i, itemElem) {
            orderPicture.push(itemElem.id);
        });
    };

    // GESTION  SUPPRESSION IMAGE
    var deletes = document.getElementsByClassName('supp-icon');
    for (var i = 0; i < deletes.length; i++) {
        deletes[i].addEventListener("click", function toggleDel(element){
            var image_id = element.target.parentNode.id;
            var image = element.target.parentNode.parentNode.childNodes[3];
            if(deletedPictures.includes(image_id)){
                //Désupprimer l'image
                deletedPictures.splice(deletedPictures.indexOf(image_id), 1);
                image.classList.remove("deleted");
            }else{
                //Supprimer l'image
                deletedPictures.push(image_id);
                image.classList.add("deleted");
            }
        });
    }
    document.getElementById('updatePictures').addEventListener("click", (element) => {
        elementClick = element;
        if(deletedPictures.length !== 0){
            $("#mi-modal").modal('show');
        }else{
            picturesAJAX(elementClick, orderPicture, deletedPictures);
        }
    });
    $("#modal-btn-si").on("click", function(){
        picturesAJAX(elementClick, orderPicture, deletedPictures);
        $("#mi-modal").modal('hide');
    });
    $("#modal-btn-no").on("click", function(){
        $("#mi-modal").modal('hide');
    });
});
function picturesAJAX(element, orderPicture, deletedPictures){
    var gallery_id = element.target.name;
    //AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../controllers/update_pictures.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            document.location.reload();
        }
    };
    var data = {orderPicture:orderPicture,gallery_id:gallery_id};
    if (deletedPictures.length !== 0){
        data = {orderPicture:orderPicture,gallery_id:gallery_id,deletedPictures:deletedPictures};
    }
    xhttp.send(JSON.stringify(data));
}
function Dropped(orderPicture){
    $(".draggable").each(function(){
        orderPicture.push($(this).attr('id'));
    });
    return orderPicture;
}