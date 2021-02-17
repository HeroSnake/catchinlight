$(document).ready(function() {
    var id;
    var page;
    var origin;
    $(".btn-confirm").each(function() {
        $(this).on("click", function(){
            id = $(this).attr("id");
            page = $(this).attr("name");
            origin = $("#myModalLabel").attr("name");
            $("#mi-modal").modal('show');
        });
    });
    $("#modal-btn-si").on("click", function(){
        modalConfirm(true, id, page, origin);
        $("#mi-modal").modal('hide');
    });
    $("#modal-btn-no").on("click", function(){
        $("#mi-modal").modal('hide');
    });
})

function modalConfirm(confirm, id, page, origin){
    if(confirm){
        var link = "../controllers/" + origin + "_delete.php";
        //AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", link, true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
            }
        };
        var data = {id:id,page:page};
        xhttp.send(JSON.stringify(data));
    }
}