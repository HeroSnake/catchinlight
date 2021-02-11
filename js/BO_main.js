window.addEventListener('load', function() {
    $('input[type=file]').change(function () {
        console.log($(this));
    });
});

function update_picture(type) {
    console.log(type);
    var string = "../img/menu/";
    if(type == "P"){
        string = "../img/accueil/containers/"
    }
    var picture = document.getElementById("image_picker").files[0].name;
    document.getElementById("preview_img").setAttribute("src", string + picture);
}

function update_text(value){
    $('#preview_text').html(value.toUpperCase());
}
